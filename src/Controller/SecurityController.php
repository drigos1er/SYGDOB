<?php

namespace App\Controller;


use App\Entity\SygdobUser;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

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
                $datenais=$useraut->getBirthdate()->format('Y-m-d');


                $hashpwd=$encoder->encodePassword($useraut, $useraut->getPassword());
                $useraut->setPassword($hashpwd);
                $useraut->setBirthdate(\DateTime::createFromFormat('Y-m-d', $datenais));
                $manager->persist($useraut);
                $manager->flush();
                $this->addFlash('success', 'Compte crée avec succès');
                return $this->redirectToRoute('security_login');
            } else {
                $datenais=$useraut->getBirthdate()->format('Y-m-d');
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
                    $useraut->setBirthdate(\DateTime::createFromFormat('Y-m-d', $datenais));
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

}
