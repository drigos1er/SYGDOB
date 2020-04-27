<?php

namespace App\Controller;


use App\Entity\ResetPwd;
use App\Entity\SygdobUser;
use App\Entity\UpdPwd;
use App\Form\RegistrationType;
use App\Form\ResettingpwdType;
use App\Form\UpdpasswordType;
use App\Form\UpdprofileType;
use App\Repository\DrenddnRepository;
use App\Repository\IeppRepository;
use App\Repository\UserieppRepository;
use Symfony\Bundle\SwiftmailerBundle;
use App\Form\ResetpwdType;
use Swift_Mailer;
use App\Repository\SygdobUserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{


    private $mailer;
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;

    }





    /**
     * Page de création d'un utillisateur
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function registration(Request $request,  UserPasswordEncoderInterface $encoder)
    {
        $useraut= new SygdobUser();
        $form= $this->createForm(RegistrationType::class, $useraut);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager= $this->getDoctrine()->getManager();



            //Verification si une image a été ajoutée
            if ($form['picture']->getData() == "") {
                //Encodage du Mot de passe

                $hashpwd=$encoder->encodePassword($useraut, $useraut->getPassword());
                $useraut->setPassword($hashpwd);

                $manager->persist($useraut);
                $manager->flush();
                $this->addFlash('success', 'Compte crée avec succès');
                return $this->redirectToRoute('security_login');
            } else {

                // Recuperation de l'image et changement de nom de l'image
                $picture= $form['picture']->getData();
                $picturename= md5(uniqid()).'.'.$picture->guessExtension();
                $extensionsAutorisees = array('jpg', 'JPG', 'jpeg', 'JPEG');

                // recuperation de la taille de l'image et verification de la taille et de l'extension
                $picturesize = $picture->getClientSize();
                if (!in_array($picture->guessExtension(), $extensionsAutorisees)) {
                    $form->get('picture')->addError(
                        new FormError(
                            "Extension  du fichier incorrect. Votre image doit être au format(
                                 \"jpg\", \"JPG\",\"jpeg\", \"JPEG\") !"
                        )
                    );
                } elseif ($picturesize > 500000) {
                    $form->get('picture')->addError(
                        new FormError(
                            "La taille de votre photo doit être inferieure à 500 Ko"
                        )
                    );
                } else {
                    //téléchargement de l'image et enregistrement de l'utilisateur
                    $picture->move($this->getParameter('upload_destination'), $picturename);
                    $hashpwd=$encoder->encodePassword($useraut, $useraut->getPassword());
                    $useraut->setPassword($hashpwd);
                    $useraut->setPicture($picturename);

                    $manager->persist($useraut);
                    $manager->flush();
                    $this->addFlash('success', 'Compte crée avec succès');
                    return $this->redirectToRoute('security_login');
                }
            }
        }
        return $this->render(
            'security/registration.html.twig',
            array(
                'form'=>$form->createView(),
                'current_menu'=>'register'
            )
        );
    }


    /**
     * Page de Connexion
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        return $this->render('security/login.html.twig', [
            'error' =>$authenticationUtils->getLastAuthenticationError(),
            'last_username' =>$authenticationUtils->getLastUsername(),
            'current_menu'=>'login'

        ]);
    }

    /**
     * formulaire  et Envoi de mail de réinitialisation
     * @param Request $request

     * @param TokenGeneratorInterface $tokenGenerator
     * @param SygdobUserRepository $userrepo
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function resetpwd(
        Request $request,
        TokenGeneratorInterface $tokenGenerator,
        SygdobUserRepository $userrepo

    ) {

            $manager= $this->getDoctrine()->getManager();
            $userreset=$userrepo->findOneByUsername($_POST['username']);
            if (!$userreset) {
               echo '<script>
    window.alert("Nom d\'utilisateur invalide");
    window.location.href=\'./login\';
    </script>';
            } else {
                // Génération et enregistrement du du token
                $userreset->setToken($tokenGenerator->generateToken());

                // enregistrement de la date de création du token
                $userreset->setTokendat(new \Datetime());
                $manager->persist($userreset);
                $manager->flush();
                $message = (new \Swift_Message('Réinitialisation de Mot de passe'))
                    ->setSubject('Réinitialisation de Mot de passe')
                    ->setFrom('dobinfo@yahoo.fr')
                    ->setTo($userreset->getEmail())
                    ->setBody(
                        $this->renderView(
                            'security/resetmail.html.twig',
                            ['userreset' => $userreset]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
                $this->addFlash(
                    'success',
                    ' Un mail  de renouvellement de  votre mot de passe a été envoyé à votre adresse mail:'.$userreset->getEmail().''
                );

                return $this->redirectToRoute('security_login');
            }
    }


    /**
     * Formulaire et enregistrement de la  réinitialisation du mot de passe
     * @param Request $request
     * @param $token
     * @param UserPasswordEncoderInterface $encoder
     * @param SygdobUser $userreset
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function resetting(
        Request $request,
        $token,
        UserPasswordEncoderInterface $encoder,
        SygdobUser $userreset
    ) {
        // Calcul de la durée du token
        $now = new \DateTime();
        $datetoken=$userreset->getTokendat();
        $delai = $now->getTimestamp() - $datetoken->getTimestamp();
        $timemax= 60 * 30;

        // Accès refusé si le token est null, token différent de celui de la base et  date de token >= 30min:
        if ($userreset->getToken() === null || $token !== $userreset->getToken() || $delai > $timemax) {
            throw new AccessDeniedHttpException("Ce lien n'est plus valide");
        }
        // Formulaire de rénitialisation
        $form= $this->createForm(ResettingpwdType::class, $userreset);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager= $this->getDoctrine()->getManager();
            // Encodage du password
            $password = $encoder->encodePassword($userreset, $userreset->getPassword());
            $userreset->setPassword($password);

            // réinitialisation du token et de sa date à null
            $userreset->setToken(null);
            $userreset->setTokendat(null);
            $manager->persist($userreset);
            $manager->flush();
            $this->addFlash('success', 'Mot de passe réinitialisé avec succès');
            return $this->redirectToRoute('security_login');
        }
        return $this->render(
            'security/resetting.html.twig',
            array('form'=>$form->createView(),
                'current_menu'=>'resetting')
        );
    }



    /**
     * Redirection des utilisateurs
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirectuser(Request $request, UserieppRepository $useriepprep, IeppRepository $iepprep, DrenddnRepository $drenrepo)
    {




        $userprofile= $this->getUser();

        $auth = $this->container->get('security.authorization_checker');



        if ($auth->isGranted('ROLE_IEPPCF')) {

            $userrole= 'ROLE_IEPPCF';
            $request->getSession()->set('userrole', $userrole);

        }


        if ($auth->isGranted('ROLE_IEPP')) {

            $userrole= 'ROLE_IEPP';
            $request->getSession()->set('userrole', $userrole);

        }



        if ($auth->isGranted('ROLE_IEPPCF')) {



            $useriepp=$useriepprep->findOneByUserid($userprofile->getUsername());
            $request->getSession()->set('useriepp', $useriepp);
            $iepp=$iepprep->findOneById($useriepp->getIeppid());
            $request->getSession()->set('iepp', $iepp);

            $dren=$drenrepo->findOneById($iepp->getDrenddn()->getId());
            $request->getSession()->set('dren', $dren);

            if ($userprofile->getPassword()== '$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.') {
                return $this->redirectToRoute('security_updpwd', array('id'=>$userprofile->getId()));
            }


            return $this->redirectToRoute('sygdob_dashboardcfiep');
        }



        if ($auth->isGranted('ROLE_IEPP')) {



            $useriepp=$useriepprep->findOneByUserid($userprofile->getUsername());
            $request->getSession()->set('useriepp', $useriepp);
            $iepp=$iepprep->findOneById($useriepp->getIeppid());
            $request->getSession()->set('iepp', $iepp);

            $dren=$drenrepo->findOneById($iepp->getDrenddn()->getId());
            $request->getSession()->set('dren', $dren);

            if ($userprofile->getPassword()== '$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.') {
                return $this->redirectToRoute('security_updpwd', array('id'=>$userprofile->getId()));
            }


            return $this->redirectToRoute('sygdob_dashboardiep');
        }








    }


    /**
     * Page de modificatrion du mot de Passe
     * @param Request $request
     * @param
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function updatepwd(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // Recuperation de l'utilisateur courant
        $user=$this->getUser();
        //Formulaire de modification de mot de passe
        $pwdupdate= new UpdPwd();
        $form= $this->createForm(UpdpasswordType::class, $pwdupdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager= $this->getDoctrine()->getManager();
            if (!password_verify($pwdupdate->getOldpwd(), $user->getPassword())) {
                $form->get('oldpwd')->addError(
                    new FormError("Ce mot de passe ne correspond pas à votre mot de passe actuel")
                );
            } else {
                //Recuperation du nouveau mot de passe, encodage et enregistrement
                $newpwd=$encoder->encodePassword($user, $pwdupdate->getNewpwd());
                $user->setPassword($newpwd);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Mot de passe modifié avec succès');
                return $this->redirectToRoute('security_logout');
            }
        }
        return $this->render(
            'security/updpassword.html.twig',
            array('form'=>$form->createView(), 'current_menu'=>'updatepwd')
        );
    }

    /**
     * Page de Déconnexion
     * @return Response
     */
    public function logout()
    {
        return $this->redirectToRoute('security_login');
    }


    /**
     * Page d'affichage et de modification du profil
     * @param Request $request
     * @param $id
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function updateprofil(Request $request, $id ,  UserPasswordEncoderInterface $encoder)
    {
        // Sauvegarde de l'image de l'utilisateur courant
        $userccpicture= $this->getUser()->getPicture();
        $request->getSession()->set('userccpicture', $userccpicture);








        //Formulaire de profil de l'utilisateur
        $userprofile= $this->getUser();
        $form= $this->createForm(UpdprofileType::class, $userprofile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager= $this->getDoctrine()->getManager();
            //Vérifie si aucune image n'est envoyer
            if ($form['picture']->getData() == "") {
                //On sauvegarde l'utilisateur

                $userprofile->setPicture($this->get('session')->get('userccpicture'));
                $userprofile->setUpdprofil(1);
                $manager->persist($userprofile);
                $manager->flush();
                $this->addFlash('success', 'Compte modifié avec succès');
                return $this->redirectToRoute('security_updprofil', array('id'=>$userprofile->getId()));
            } else {
                //On recupère l'image
                $picture= $form['picture']->getData();
                // On recupère l'extenseion et la taille de l'image
                $picturename= md5(uniqid()).'.'.$picture->guessExtension();
                $extensionsAutorisees = array('jpg', 'JPG', 'jpeg', 'JPEG');
                $picturesize = $picture->getClientSize();

                // on met des restrictions sur la taille et l'extension
                if (!in_array($picture->guessExtension(), $extensionsAutorisees)) {
                    $form->get('picture')->addError(
                        new FormError("Extension  du fichier incorrect. 
                        Votre image doit être au format(\"jpg\", \"JPG\",\"jpeg\", \"JPEG\") !")
                    );
                } elseif ($picturesize > 500000) {
                    $form->get('picture')->addError(
                        new FormError("La taille de votre photo doit être inferieure à 500 Ko")
                    );
                } else {
                    //on telecharge l'image et on sauvegarde l'utilisateur
                    $picture->move($this->getParameter('upload_destination'), $picturename);
                    $userprofile->setPicture($picturename);
                    $userprofile->setUpdprofil(1);
                    $manager->persist($userprofile);
                    $manager->flush();
                    $this->addFlash('success', 'Compte modifié avec succès');
                    return $this->redirectToRoute('security_updprofil', array('id'=>$userprofile->getId()));
                }
            }
        }
        return $this->render(
            'security/updprofil.html.twig',
            array('form'=>$form->createView(), 'current_menu'=>'updateprofil','userprofil'=>$userprofile)
        );
    }







}
