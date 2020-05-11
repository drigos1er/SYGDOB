<?php

namespace App\Controller;

use App\Entity\Drenddn;
use App\Entity\Iepp;
use App\Entity\SecondarySchool;
use App\Entity\Student;
use App\Form\DrenddnType;
use App\Form\EditStudentType;
use App\Form\IeppType;
use App\Form\InsertschoolType;
use App\Form\InsertStudentType;
use App\Form\mateditstudentType;
use App\Form\StudenthdType;
use App\Form\UsermatType;
use App\Form\UserstructureType;
use App\Repository\DrenddnRepository;
use App\Repository\IeppRepository;
use App\Repository\PrimarySchoolRepository;
use App\Repository\SecondarySchoolRepository;
use App\Repository\StudentRepository;
use App\Repository\SygdobRoleRepository;
use App\Repository\SygdobUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;

class DobadminController extends AbstractController
{
    /**
     * Dashboard  DOBADMIN
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboarddobadmin()
    {

        return $this->render('dobadmin/dashboarddobadmin.html.twig');
    }





    public function tablerecapwishdobadmin(Request $request)
    {





        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentf', 'nbstudentf');

        $sql = "SELECT count(*) as nbstudentf FROM `student`  WHERE   kind='F'   ";
        $query = $em->createNativeQuery($sql, $rsm);


        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdf= $nwi['nbstudentf'];

        }




        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentm', 'nbstudentm');

        $sql = "SELECT count(*) as nbstudentm FROM `student`  WHERE   kind='M'   ";
        $query = $em->createNativeQuery($sql, $rsm);


        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdm= $nwi['nbstudentm'];

        }


        $nbstd=$nbstdm+$nbstdf;


        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

        $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE   wish1!=''   ";
        $query = $em->createNativeQuery($sql, $rsm);


        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdwish= $nwi['nbstudentwish'];

        }




        $taux=number_format(($nbstdwish*100)/$nbstd,2);





        return  $this->render('dobadmin/tablerecapwishdobadmin.html.twig',array('nbstdf'=>$nbstdf,'nbstdm'=>$nbstdm,'nbstd'=>$nbstd,'nbstdwish'=>$nbstdwish,'taux'=>$taux));



    }




    public function tablerecapwishbydrendobadm(Request $request)
    {

        return  $this->render('dobadmin/tablerecapwishbydrendobadm.html.twig');



    }







    public function listtablerecapwishbydrendobadm(Request $request,DrenddnRepository $drenrepo)
    {


        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $drenrepo->searchdren($filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($drenrepo->searchdren( $filters, 0, false)),
            'recordsTotal' => count($drenrepo->searchdren( 0, false))
        );

        foreach ($users as $sch) {






            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudent', 'nbstudent');

            $sql = "SELECT count(*) as nbstudent FROM `student`  WHERE  dren=:dren   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('dren', $sch->getId());

            $aver= $query->getResult();


            foreach ($aver as $n) {
                $nbstd= $n['nbstudent'];

            }


            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

            $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE  dren=:dren and wish1!=''   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('dren', $sch->getId());

            $averw= $query->getResult();


            foreach ($averw as $nwi) {
                $nbstdwish= $nwi['nbstudentwish'];

            }




            $taux=number_format(($nbstdwish*100)/$nbstd,2);


            $pathmat=  $this->generateUrl('sygdob_redirecttablerecapwishbyiepdobadm',array('dren'=>$sch->getId()))  ;




            $lienschool = '
            <a href="'.$pathmat.'" type="button"
                                                class="btn waves-effect waves-light btn-success text-center"><i class="fa fa-search-plus"></i>Voir</a>';





            $output['data'][] = [







                'school' => $sch->getDrenname(),
                'std' => $nbstd,
                'stdwish' => $nbstdwish,
                'taux' => $taux,
                'more' => $lienschool,

            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }






    public function redirecttablerecapwishbyiepdobadm(Request $request, DrenddnRepository $drenddnrepo)
    {


        $drenddnbyiep=$drenddnrepo->findOneById($request->query->get('dren'));

        $request->getSession()->set('iddren', $request->query->get('dren'));


        $request->getSession()->set('drenddnnamebyiep', $drenddnbyiep->getDrenname());
        return $this->redirectToRoute('sygdob_tablerecapwishbyiepdobadm');






    }




    public function tablerecapwishbyiepdobadm(Request $request)
    {

        return  $this->render('dobadmin/tablerecapwishbyiepdobadm.html.twig');



    }







    public function listtablerecapwishbyiepdobadm(Request $request,IeppRepository $iepprepo)
    {



        $iddren=$this->get('session')->get('iddren');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $iepprepo->searchiepp($iddren,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($iepprepo->searchiepp($iddren, $filters, 0, false)),
            'recordsTotal' => count($iepprepo->searchiepp($iddren, 0, false))
        );

        foreach ($users as $sch) {


            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudent', 'nbstudent');

            $sql = "SELECT count(*) as nbstudent FROM `student`  WHERE  iepp=:iepp   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('iepp', $sch->getId());

            $aver= $query->getResult();


            foreach ($aver as $n) {
                $nbstd= $n['nbstudent'];

            }


            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

            $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE  iepp=:iepp and wish1!=''   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('iepp', $sch->getId());

            $averw= $query->getResult();


            foreach ($averw as $nwi) {
                $nbstdwish= $nwi['nbstudentwish'];

            }




            $taux=number_format(($nbstdwish*100)/$nbstd,2);


            $pathmat=  $this->generateUrl('sygdob_redirecttablerecapwishbyschooldobadm',array('iepp'=>$sch->getId()))  ;




            $lienschool = '
            <a href="'.$pathmat.'" type="button"
                                                class="btn waves-effect waves-light btn-success text-center"><i class="fa fa-search-plus"></i>Voir</a>';





            $output['data'][] = [







                'school' => $sch->getIeppname(),
                'std' => $nbstd,
                'stdwish' => $nbstdwish,
                'taux' => $taux,
                'more' => $lienschool,

            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }





    public function redirecttablerecapwishbyschooldobadm(Request $request, IeppRepository $iepprep)
    {




        $ieppbyschooldob=$iepprep->findOneById($request->query->get('iepp'));
        $request->getSession()->set('idiepp', $request->query->get('iepp'));

        $request->getSession()->set('ieppnamebyschooldob', $ieppbyschooldob->getIeppname());
        return $this->redirectToRoute('sygdob_tablerecapwishbyschooldobadm');






    }





    public function tablerecapwishbyschooldobadm(Request $request)
    {

        return  $this->render('dobadmin/tablerecapwishbyschooldobadm.html.twig');



    }







    public function listtablerecapwishbyschooldobadm(Request $request,PrimarySchoolRepository $primscorep)
    {



        $idiepp=$this->get('session')->get('idiepp');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $primscorep->searchprimschool($idiepp,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($primscorep->searchprimschool($idiepp, $filters, 0, false)),
            'recordsTotal' => count($primscorep->searchprimschool($idiepp, 0, false))
        );

        foreach ($users as $sch) {


            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudent', 'nbstudent');

            $sql = "SELECT count(*) as nbstudent FROM `student`  WHERE  school=:school   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('school', $sch->getId());

            $aver= $query->getResult();


            foreach ($aver as $n) {
                $nbstd= $n['nbstudent'];

            }


            $em = $this->getDoctrine()->getManager();


            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

            $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE  school=:school and wish1!=''   ";
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter('school', $sch->getId());

            $averw= $query->getResult();


            foreach ($averw as $nwi) {
                $nbstdwish= $nwi['nbstudentwish'];

            }




            $taux=number_format(($nbstdwish*100)/$nbstd,2);




            $output['data'][] = [







                'school' => $sch->getSchoolname(),
                'std' => $nbstd,
                'stdwish' => $nbstdwish,
                'taux' => $taux,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }






















    public function insertstudent(Request $request,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep)
    {


        $student= new Student();
        $form= $this->createForm(InsertStudentType::class, $student);




        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $manager= $this->getDoctrine()->getManager();


            $iepp=$iepprep->findOneBy(array('drenddn'=>$form['dren']->getData()->getId(),'id'=>$form['iepp']->getData()->getId()));
            $myschool=$primschoolrep->findOneBy(array('iepp'=>$form['iepp']->getData()->getId(),'id'=>$form['school']->getData()));

            $school=$primschoolrep->findOneById(array($form['school']->getData()));


            if(!$school){


                $this->addFlash('error', "Code Ecole invalide .");
                return $this->redirectToRoute('sygdob_insertstudent');




            }elseif (!$iepp) {

                $ieppname=$form['iepp']->getData()->getIeppname();
                $drenname=$form['dren']->getData()->getDrenname();


                $this->addFlash('error', "L'IEPP     $ieppname n'est pas de la DRENETFP  $drenname .");
                return $this->redirectToRoute('sygdob_insertstudent');






            }elseif (!$myschool) {

                $ieppname=$form['iepp']->getData()->getIeppname();

                $schoolname=$school->getSchoolname();
                $this->addFlash('error', "L'école     $schoolname n'est pas de l'IEPP  $ieppname .");
                return $this->redirectToRoute('sygdob_insertstudent');





            }else{


                $student->setDren($form['dren']->getData()->getId());
                $student->setIepp($form['iepp']->getData()->getId());
                $student->setSchool($form['school']->getData());

                $manager->persist($student);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboarddobadmin');




            }







            }












        return  $this->render('dobadmin/insertstudent.html.twig', array('form'=>$form->createView()));
    }





    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mateditstudent(Request $request, StudentRepository $stdrepo)
    {






        $form= $this->createForm(mateditstudentType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $stdcand=$stdrepo->findOneById($form['id']->getData());


            if(!$stdcand){
                $this->addFlash('error', 'Matricule abasent de la base des candidats   !');
                return $this->redirectToRoute('sygdob_mateditstudent');

            }
            else {

                $request->getSession()->set('stdcand', $stdcand);


                return $this->redirectToRoute('sygdob_editstudent');

            }
















        }


        return $this->render('dobadmin/mateditstudent.html.twig', [
            'form'=>$form->createView()
        ]);
    }









    public function editstudent(Request $request,StudentRepository $studrep,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep, DrenddnRepository $drenrepo)
    {



        $stdedit=$studrep->findOneById($this->get('session')->get('stdcand')->getId());


         $defaultdren=$drenrepo->findOneById($stdedit->getDren());
        $defaultiepp=$iepprep->findOneById($stdedit->getIepp());
        $defaultschool=$primschoolrep->findOneById($stdedit->getSchool());




        $form= $this->createForm(EditStudentType::class, $stdedit,array('dren'=>$defaultdren,'iepp'=>$defaultiepp,'school'=>$defaultschool));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $manager= $this->getDoctrine()->getManager();


            $iepp=$iepprep->findOneBy(array('drenddn'=>$form['dren']->getData()->getId(),'id'=>$form['iepp']->getData()->getId()));
            $myschool=$primschoolrep->findOneBy(array('iepp'=>$form['iepp']->getData()->getId(),'id'=>$form['school']->getData()));


            $school=$primschoolrep->findOneById(array($form['school']->getData()));


            if(!$school){


                $this->addFlash('error', "Code Ecole invalide .");
                return $this->redirectToRoute('sygdob_insertstudent');




            }
            elseif (!$iepp) {

                $ieppname=$form['iepp']->getData()->getIeppname();
                $drenname=$form['dren']->getData()->getDrenname();


                $this->addFlash('error', "L'IEPP     $ieppname n'est pas de la DRENETFP  $drenname .");
                return $this->redirectToRoute('sygdob_editstudent');






            }elseif (!$myschool) {


                $ieppname=$form['iepp']->getData()->getIeppname();

                $schoolname=$school->getSchoolname();
                $this->addFlash('error', "L'école     $schoolname n'est pas de l'IEPP  $ieppname .");
                return $this->redirectToRoute('sygdob_editstudent');





            }else{


                $stdedit->setDren($form['dren']->getData()->getId());
                $stdedit->setIepp($form['iepp']->getData()->getId());
                $stdedit->setSchool($form['school']->getData());

                $manager->persist($stdedit);
                $manager->flush();
                $this->addFlash('success', 'candidat Modifié avec succès');
                return $this->redirectToRoute('sygdob_mateditstudent');




            }







        }












        return  $this->render('dobadmin/editstudent.html.twig', array('form'=>$form->createView()));
    }




    public function insertschool(Request $request,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep)
    {


        $school= new SecondarySchool();
        $form= $this->createForm(InsertschoolType::class, $school);




        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $manager= $this->getDoctrine()->getManager();






                $manager->persist($school);
                $manager->flush();
                $this->addFlash('success', 'Etablissement enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboarddobadmin');




            }




















        return  $this->render('dobadmin/insertschool.html.twig', array('form'=>$form->createView()));
    }





    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function usermanagmt()
    {

        $iep= new Iepp();
        $dren= new Drenddn();

        $form= $this->createForm(IeppType::class, $iep);
        $form1= $this->createForm(UsermatType::class);
 $form2= $this->createForm(DrenddnType::class,$dren);

        $form3= $this->createForm(UserstructureType::class);


        return $this->render('dobadmin/viewuserdobadm.html.twig', [
            'form'=>$form->createView(),'form2'=>$form2->createView(),'form1'=>$form1->createView(),'form3'=>$form3->createView()
        ]);
    }


    public function redirecttableuserbyiep(Request $request)
    {

        $tecol=$_POST["iepp"];
        $idiepp=$tecol["ieppname"];
        $request->getSession()->set('idiepp', $idiepp);


        return $this->redirectToRoute('sygdob_tableuserbyiep');






    }





    public function tableuserbyiep(Request $request, IeppRepository $iepprepo)
    {



        $iepp=$iepprepo->findOneById($this->get('session')->get('idiepp'));



        return  $this->render('dobadmin/tableuserbyiep.html.twig', array('iepp'=>$iepp));



    }







    public function listtableuserbyiep(Request $request,SygdobUserRepository $syguserrep)
    {



        $idiepp=$this->get('session')->get('idiepp');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $syguserrep->searchuseriepp($idiepp,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($syguserrep->searchuseriepp($idiepp, $filters, 0, false)),
            'recordsTotal' => count($syguserrep->searchuseriepp($idiepp, 0, false))
        );

        foreach ($users as $usr) {


           $pictureusr=$usr->getPicture();

          if($pictureusr==""){

              $tof='<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" width="30" class="profile-pic rounded-circle" />' ;

          }else{

              $tof='     <img onclick="window.open(this.src,\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=\'+this.width+\', height=\'+this.height);" src="/SYGDOB/public/images/users/'.$pictureusr.'" alt="user" width="30" class="profile-pic rounded-circle" />' ;
          }




  if($usr->getEnabled()==1){







      $pathstatus=  $this->generateUrl('sygdob_deactivateuserdobiep',array('login'=>$usr->getUsername()));



      $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-success text-center" title="Cliquer pour désactiver le compte"><i class="mdi mdi-account-check "></i></a>';



  }else{


      $pathstatus=  $this->generateUrl('sygdob_activateuserdobiep',array('login'=>$usr->getUsername()));

      $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-danger text-center" title="Cliquer pour activer le compte"><i class="mdi mdi-account-off "></i></a>';


  }


            $pathreset=  $this->generateUrl('sygdob_resetuserdobiep',array('login'=>$usr->getUsername()));
            $lienreset = '<a href="'.$pathreset.'" type="button" class="btn waves-effect waves-light btn-warning text-center" title="Cliquer pour réinitialiser le compte"><i class="mdi mdi-account-convert "></i></a>';


            $pathremove=  $this->generateUrl('sygdob_alertdeleteuseriep',array('login'=>$usr->getUsername(),'id'=>$usr->getId()));

            $lienremove = ' <a href="'.$pathremove.'" type="button" class="btn waves-effect waves-light btn-primary text-center" title="Cliquer pour supprimer le compte" ><i class="mdi mdi-account-remove"></i></a>
 
 
 
 
 
 ';







            if($usr->getUserrole()==1){
                $userrole='Correspondant Fichier';
            }

            if($usr->getUserrole()==2){
                $userrole='IEP';
            }




            $output['data'][] = [







                'tof' => $tof,
                'login' => $usr->getUsername(),
                'firstname' => $usr->getFirstname(),
                'lastname' => $usr->getLastname(),
                'phone' => $usr->getPhone(),
                'email' => $usr->getEmail(),
                'role' => $userrole,
                'status' => $lienstatus,
                'reset' => $lienreset,
                'remove' => $lienremove,
            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }





    public function deactivateuserdobiep( Request $request)
    {


        $sql = " UPDATE sygdob_user SET enabled=0 WHERE username=:username   ";
        $params = array('username'=> $request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);




            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte désactivé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableuserbyiep');














    }



    public function activateuserdobiep( Request $request)
    {









        $sql = " UPDATE sygdob_user SET enabled=1 WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte activé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableuserbyiep');










    }



    public function resetuserdobiep( Request $request)
    {


        $pwd='$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.';






        $sql = " UPDATE sygdob_user SET enabled=1, password=:password WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'),'password'=>$pwd);

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte réinitialisé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableuserbyiep');










    }




    public function alertedeleteuseriep(Request $request)
    {



        return  $this->render('dobadmin/alertdeleteuseriep.html.twig',array('login'=>$request->query->get('login'),'id'=>$request->query->get('id')));



    }





    public function deleteuserdobiep( Request $request)
    {






        $sql = " DELETE FROM sygdob_role_sygdob_user  WHERE sygdob_user_id=:username   ";
        $params = array('username'=>$request->query->get('id'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);








        $sql = " DELETE FROM sygdob_user  WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);



        $sql = " DELETE FROM useriepp  WHERE userid=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);






            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte supprimé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableuserbyiep');












    }






    public function redirecttableuserbydren(Request $request)
    {

        $tecol=$_POST["drenddn"];


        $iddren=$tecol["drenname"];
        $request->getSession()->set('iddren', $iddren);


        return $this->redirectToRoute('sygdob_tableuserbydren');






    }





    public function tableuserbydren(Request $request, DrenddnRepository $drenrepo)
    {



        $dren=$drenrepo->findOneById($this->get('session')->get('iddren'));



        return  $this->render('dobadmin/tableuserbydren.html.twig', array('dren'=>$dren));



    }







    public function listtableuserbydren(Request $request,SygdobUserRepository $syguserrep)
    {



        $iddren=$this->get('session')->get('iddren');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $syguserrep->searchuserdren($iddren,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($syguserrep->searchuserdren($iddren, $filters, 0, false)),
            'recordsTotal' => count($syguserrep->searchuserdren($iddren, 0, false))
        );

        foreach ($users as $usr) {


            $pictureusr=$usr->getPicture();

            if($pictureusr==""){

                $tof='<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" width="30" class="profile-pic rounded-circle" />' ;

            }else{

                $tof='     <img src="/SYGDOB/public/images/users/'.$pictureusr.'" alt="user" width="30" class="profile-pic rounded-circle" onclick="window.open(this.src,\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=\'+this.width+\', height=\'+this.height);" />' ;
            }




            if($usr->getEnabled()==1){







                $pathstatus=  $this->generateUrl('sygdob_deactivateuserdobdren',array('login'=>$usr->getUsername()));



                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-success text-center" title="Cliquer pour désactiver le compte"><i class="mdi mdi-account-check "></i></a>';



            }else{


                $pathstatus=  $this->generateUrl('sygdob_activateuserdobdren',array('login'=>$usr->getUsername()));

                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-danger text-center" title="Cliquer pour activer le compte"><i class="mdi mdi-account-off "></i></a>';


            }


            $pathreset=  $this->generateUrl('sygdob_resetuserdobdren',array('login'=>$usr->getUsername()));
            $lienreset = '<a href="'.$pathreset.'" type="button" class="btn waves-effect waves-light btn-warning text-center" title="Cliquer pour réinitialiser le compte"><i class="mdi mdi-account-convert "></i></a>';


            $pathremove=  $this->generateUrl('sygdob_alertdeleteuserdren',array('login'=>$usr->getUsername(),'id'=>$usr->getId()));

            $lienremove = ' <a href="'.$pathremove.'" type="button" class="btn waves-effect waves-light btn-primary text-center" title="Cliquer pour supprimer le compte" ><i class="mdi mdi-account-remove"></i></a>
 
 
 
 
 
 ';







            if($usr->getUserrole()==6){
                $userrole='Correspondant CIO';
            }

            if($usr->getUserrole()==3){
                $userrole='DCIO';
            }




            $output['data'][] = [







                'tof' => $tof,
                'login' => $usr->getUsername(),
                'firstname' => $usr->getFirstname(),
                'lastname' => $usr->getLastname(),
                'phone' => $usr->getPhone(),
                'email' => $usr->getEmail(),
                'role' => $userrole,
                'status' => $lienstatus,
                'reset' => $lienreset,
                'remove' => $lienremove,
            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }





    public function deactivateuserdobdren( Request $request)
    {


        $sql = " UPDATE sygdob_user SET enabled=0 WHERE username=:username   ";
        $params = array('username'=> $request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);




        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte désactivé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbydren');














    }



    public function activateuserdobdren( Request $request)
    {









        $sql = " UPDATE sygdob_user SET enabled=1 WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte activé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbydren');










    }



    public function resetuserdobdren( Request $request)
    {


        $pwd='$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.';






        $sql = " UPDATE sygdob_user SET enabled=1, password=:password WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'),'password'=>$pwd);

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte réinitialisé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbydren');










    }




    public function alertedeleteuserdren(Request $request)
    {



        return  $this->render('dobadmin/alertdeleteuserdren.html.twig',array('login'=>$request->query->get('login'),'id'=>$request->query->get('id')));



    }





    public function deleteuserdobdren( Request $request)
    {






        $sql = " DELETE FROM sygdob_role_sygdob_user  WHERE sygdob_user_id=:username   ";
        $params = array('username'=>$request->query->get('id'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);








        $sql = " DELETE FROM sygdob_user  WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);



        $sql = " DELETE FROM useriepp  WHERE userid=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);






        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte supprimé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbydren');












    }






    public function redirecttableuserbystruct(Request $request)
    {


        $tecol=$_POST["userstructure"];


        $idstruct=$tecol["structure"];


        $request->getSession()->set('idstruct', $idstruct);


        return $this->redirectToRoute('sygdob_tableuserbystruct');






    }





    public function tableuserbystruct(Request $request)
    {



        $struct=$this->get('session')->get('idstruct');



        return  $this->render('dobadmin/tableuserbystruct.html.twig', array('struct'=>$struct));



    }







    public function listtableuserbystruct(Request $request,SygdobUserRepository $syguserrep)
    {



        $idstruct=$this->get('session')->get('idstruct');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $syguserrep->searchuserstruct($idstruct,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($syguserrep->searchuserstruct($idstruct, $filters, 0, false)),
            'recordsTotal' => count($syguserrep->searchuserstruct($idstruct, 0, false))
        );

        foreach ($users as $usr) {


            $pictureusr=$usr->getPicture();

            if($pictureusr==""){

                $tof='<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" width="30" class="profile-pic rounded-circle" />' ;

            }else{

                $tof='     <img src="/SYGDOB/public/images/users/'.$pictureusr.'" alt="user" width="30" class="profile-pic rounded-circle"  onclick="window.open(this.src,\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=\'+this.width+\', height=\'+this.height);" />' ;
            }




            if($usr->getEnabled()==1){







                $pathstatus=  $this->generateUrl('sygdob_deactivateuserdobstruct',array('login'=>$usr->getUsername()));



                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-success text-center" title="Cliquer pour désactiver le compte"><i class="mdi mdi-account-check "></i></a>';



            }else{


                $pathstatus=  $this->generateUrl('sygdob_activateuserdobstruct',array('login'=>$usr->getUsername()));

                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-danger text-center" title="Cliquer pour activer le compte"><i class="mdi mdi-account-off "></i></a>';


            }


            $pathreset=  $this->generateUrl('sygdob_resetuserdobstruct',array('login'=>$usr->getUsername()));
            $lienreset = '<a href="'.$pathreset.'" type="button" class="btn waves-effect waves-light btn-warning text-center" title="Cliquer pour réinitialiser le compte"><i class="mdi mdi-account-convert "></i></a>';


            $pathremove=  $this->generateUrl('sygdob_alertdeleteuserstruct',array('login'=>$usr->getUsername(),'id'=>$usr->getId()));

            $lienremove = ' <a href="'.$pathremove.'" type="button" class="btn waves-effect waves-light btn-primary text-center" title="Cliquer pour supprimer le compte" ><i class="mdi mdi-account-remove"></i></a>
 
 
 
 
 
 ';







            if($usr->getUserrole()==4){
                $userrole='Informaticien DOB';
            }

            if($usr->getUserrole()==9){
                $userrole='Secrétariat DOB';
            }

            if($usr->getUserrole()==8){
                $userrole='Utilisateur POSTCNO';
            }

            if($usr->getUserrole()==5){
                $userrole='Administrateur';
            }


            $output['data'][] = [







                'tof' => $tof,
                'login' => $usr->getUsername(),
                'firstname' => $usr->getFirstname(),
                'lastname' => $usr->getLastname(),
                'phone' => $usr->getPhone(),
                'email' => $usr->getEmail(),
                'role' => $userrole,
                'status' => $lienstatus,
                'reset' => $lienreset,
                'remove' => $lienremove,
            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }





    public function deactivateuserdobstruct( Request $request)
    {


        $sql = " UPDATE sygdob_user SET enabled=0 WHERE username=:username   ";
        $params = array('username'=> $request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);




        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte désactivé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbystruct');














    }



    public function activateuserdobstruct( Request $request)
    {









        $sql = " UPDATE sygdob_user SET enabled=1 WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte activé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbystruct');










    }



    public function resetuserdobstruct( Request $request)
    {


        $pwd='$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.';






        $sql = " UPDATE sygdob_user SET enabled=1, password=:password WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'),'password'=>$pwd);

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);







        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte réinitialisé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbystruct');










    }




    public function alertedeleteuserstruct(Request $request)
    {



        return  $this->render('dobadmin/alertdeleteuserstruct.html.twig',array('login'=>$request->query->get('login'),'id'=>$request->query->get('id')));



    }





    public function deleteuserdobstruct( Request $request)
    {






        $sql = " DELETE FROM sygdob_role_sygdob_user  WHERE sygdob_user_id=:username   ";
        $params = array('username'=>$request->query->get('id'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);








        $sql = " DELETE FROM sygdob_user  WHERE username=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);



        $sql = " DELETE FROM useriepp  WHERE userid=:username   ";
        $params = array('username'=>$request->query->get('login'));

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);






        $this->get('session')->getFlashBag()->add(
            'success',
            'Compte supprimé  avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tableuserbystruct');












    }





    public function redirecttableuserbymat(Request $request,SygdobUserRepository $sygdobuserrepo,SygdobRoleRepository $sygrolerep, IeppRepository $iepprep, DrenddnRepository $drenddnRepos)
    {


        $tecol=$_POST["usermat"];


        $iduser=$tecol["username"];



        $syguser=$sygdobuserrepo->findOneByUsername($iduser);


        if(!$syguser){
            $this->addFlash('error', 'Utilisateur inexistant  !');
            return $this->redirectToRoute('sygdob_usermanagmt');

        }

        $userole=$sygrolerep->findOneById($syguser->getUserrole());


        if($syguser->getUserrole() =='1') {
            $useriep=$iepprep->findOneById($syguser->getUserstructure());
            $request->getSession()->set('syguser', $syguser);
            $request->getSession()->set('userole', $userole);
            $request->getSession()->set('useriep', $useriep);

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }elseif($syguser->getUserrole() =='2') {
            $useriep=$iepprep->findOneById($syguser->getUserstructure());
            $request->getSession()->set('syguser', $syguser);
            $request->getSession()->set('userole', $userole);
            $request->getSession()->set('useriep', $useriep);

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }elseif($syguser->getUserrole() =='3') {
            $useriep=$drenddnRepos->findOneById($syguser->getUserstructure());
            $request->getSession()->set('syguser', $syguser);
            $request->getSession()->set('userole', $userole);
            $request->getSession()->set('useriep', $useriep);

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }elseif($syguser->getUserrole() =='6') {
            $useriep=$drenddnRepos->findOneById($syguser->getUserstructure());
            $request->getSession()->set('syguser', $syguser);
            $request->getSession()->set('userole', $userole);
            $request->getSession()->set('useriep', $useriep);

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }else {
            $useriep=$syguser->getUserstructure();
            $request->getSession()->set('syguser', $syguser);
            $request->getSession()->set('userole', $userole);
            $request->getSession()->set('useriep', $useriep);

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }













    }



    public function tableviewuserdobadm(Request $request, SygdobUserRepository $syguserrepo)
    {

        $userpro=$syguserrepo->findOneByUsername($this->get('session')->get('syguser')->getUsername());

        return  $this->render('dobadmin/tableviewuserdobadm.html.twig',array('userpro'=>$userpro));



    }



}
