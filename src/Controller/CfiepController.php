<?php

namespace App\Controller;

use App\Entity\PrimarySchool;
use App\Entity\Student;
use App\Form\PrimaryschoolType;
use App\Form\StudenthdType;
use App\Form\StudentmatType;
use App\Form\StudentType;
use App\Repository\IeppRepository;
use App\Repository\LocalityRepository;
use App\Repository\PrimarySchoolRepository;
use App\Repository\SecondarySchoolRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CfiepController extends AbstractController
{
    /**
     * Dashboard CF IEPP
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardcfiep()
    {

        $id=$this->get('session')->get('iepp')->getId();


        $primschool= new PrimarySchool();
        $studentmat= new Student();
        $form= $this->createForm(PrimaryschoolType::class, $primschool,array(
            'id' => $id));
        $form2= $this->createForm(StudentmatType::class, $studentmat);



        return $this->render('cfiep/dashboardcfiep.html.twig', [
            'form'=>$form->createView(),'form2'=>$form2->createView()
        ]);
    }


    public function redirecttablestudentbyschoolcf(Request $request)
    {

             $tecol=$_POST["primaryschool"];
            $idschoolist=$tecol["schoolname"];
        $request->getSession()->set('idschoolist', $idschoolist);


        return $this->redirectToRoute('sygdob_tablestudentbyschoolcf');






    }






    public function redirecteditwishstudent(Request $request, StudentRepository $studrepo)
    {

        $stdt=$_POST["studentmat"];
        $idstudent=$stdt["id"];
         $cand=$studrepo->findOneById($idstudent);

         if(!$cand){
             $this->addFlash('error', 'Matricule inexistant dans la base des candidats !');
             return $this->redirectToRoute('sygdob_dashboardcfiep');

         }elseif ($cand->getIepp()!=$this->get('session')->get('iepp')->getId()){


             $this->addFlash('error', 'Ce candidat n\'est pas de votre IEPP !');
             return $this->redirectToRoute('sygdob_dashboardcfiep');



         }



         else{

             return $this->redirectToRoute('sygdob_editwishstudentmat',array('id'=>$idstudent));

         }









    }


















    public function tablestudentbyschoolcf(Request $request, PrimarySchoolRepository $primschoolrepo)
    {



        $primschool=$primschoolrepo->findOneById($this->get('session')->get('idschoolist'));



        return  $this->render('cfiep/tablestudentbyschoolcf.html.twig', array('primschool'=>$primschool));



    }







    public function listtablestudentbyschoolcf(Request $request,StudentRepository $studrepo, SecondarySchoolRepository $secschoolrep)
    {



        $idschool=$this->get('session')->get('idschoolist');




        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $studrepo->searchstudentschool($idschool,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($studrepo->searchstudentschool($idschool, $filters, 0, false)),
            'recordsTotal' => count($studrepo->searchstudentschool($idschool, 0, false))
        );

        foreach ($users as $std) {





            $pathmat=  $this->generateUrl('sygdob_editwishstudent',array('id'=>$std->getId()))  ;




            $lienmat = '<a href="'.$pathmat.'" class="text-center"><img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" class="rounded-circle" width="30" />'. $std->getId().'</a>';








            $nwish1=$secschoolrep->findOneById($std->getWish1());

            if(!$nwish1){
                $nawish1="";
            }else{

                $nawish1=$nwish1->getSchoolname();
            }
            $nwish2=$secschoolrep->findOneById($std->getWish2());

            if(!$nwish2){
                $nawish2="";
            }else{

                $nawish2=$nwish2->getSchoolname();
            }



            $nwish3=$secschoolrep->findOneById($std->getWish3());

            if(!$nwish3){
                $nawish3="";
            }else{

                $nawish3=$nwish3->getSchoolname();
            }

            $output['data'][] = [







               'mat' => $lienmat,
                'first' => $std->getFirstname(),
                'last' => $std->getLastname(),
                'birth' => $std->getBirthdate()->format('d/m/Y'),
                'place' => $std->getPlaceofbirth(),
                'kind' => $std->getKind(),
                'nat' => $std->getNationality(),
                'resid' => $std->getResidence(),
                'wish1' => $nawish1,
                'wish2' => $nawish2,
                'wish3' => $nawish3,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }




    public function editwishstudent(Request $request, Student $std, IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

     $iepp=$iepprep->findOneById($std->getIepp());
         $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudentType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

      $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


       $kwish1name=$kwish1->getSchoolname();

       $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
            $updbirthdate=0;
       }else{
           $updbirthdate=1;

       }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                        $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                        return $this->redirectToRoute('sygdob_editwishstudent', array('id'=>$std->getId()));






                    }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                        $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                        return $this->redirectToRoute('sygdob_editwishstudent', array('id'=>$std->getId()));



                    }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                        $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                        return $this->redirectToRoute('sygdob_editwishstudent', array('id'=>$std->getId()));



                    }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_tablestudentbyschoolcf');




            }















             }


        return  $this->render('cfiep/editwishstudent.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }












    public function editwishstudenthd(Request $request, Student $std,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

        $iepp=$iepprep->findOneById($std->getIepp());
        $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudenthdType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

            $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


            $kwish1name=$kwish1->getSchoolname();

            $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
                $updbirthdate=0;
            }else{
                $updbirthdate=1;

            }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthd', array('id'=>$std->getId()));






            }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthd', array('id'=>$std->getId()));



            }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthd', array('id'=>$std->getId()));



            }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_tablestudentbyschoolcf');




            }









        }


        return  $this->render('cfiep/editwishstudenthd.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }







    public function tablerecapeditcf(Request $request)
    {

        return  $this->render('cfiep/tablerecapeditcf.html.twig');



    }







    public function listtablerecapeditcf(Request $request,PrimarySchoolRepository $primscorep)
    {



        $idiepp=$this->get('session')->get('iepp')->getId();




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




                        $pathmat=  $this->generateUrl('sygdob_editwishstudent',array('id'=>$sch->getId()))  ;


                        $lienexport = '<a href="'.$pathmat.'"><span class="badge badge-warning text-white mr-2"><i
                                                class="ti-export"></i></span> </a>';


            $output['data'][] = [







                'school' => $sch->getSchoolname(),
                'std' => $nbstd,
                'stdwish' => $nbstdwish,
                'taux' => $taux,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }






    public function editwishstudentmat(Request $request, Student $std, IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

        $iepp=$iepprep->findOneById($std->getIepp());
        $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudentType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

            $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


            $kwish1name=$kwish1->getSchoolname();

            $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
                $updbirthdate=0;
            }else{
                $updbirthdate=1;

            }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentmat', array('id'=>$std->getId()));






            }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentmat', array('id'=>$std->getId()));



            }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentmat', array('id'=>$std->getId()));



            }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboardcfiep');




            }















        }


        return  $this->render('cfiep/editwishstudentmat.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }




    public function editwishstudenthdmat(Request $request, Student $std,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

        $iepp=$iepprep->findOneById($std->getIepp());
        $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudenthdType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

            $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


            $kwish1name=$kwish1->getSchoolname();

            $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
                $updbirthdate=0;
            }else{
                $updbirthdate=1;

            }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdmat', array('id'=>$std->getId()));






            }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdmat', array('id'=>$std->getId()));



            }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdmat', array('id'=>$std->getId()));



            }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboardcfiep');




            }









        }


        return  $this->render('cfiep/editwishstudenthdmat.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }







    public function redirecttablestudentbyname(Request $request, StudentRepository $studrepo)
    {

        $stdname=$_POST["stdname"];

        $request->getSession()->set('stdname', $stdname);

            return $this->redirectToRoute('sygdob_tablestudentbyname');

        }





















    public function tablestudentbyname()
    {





        return  $this->render('cfiep/tablestudentbyname.html.twig');



    }







    public function listtablestudentbyname(Request $request,StudentRepository $studrepo, SecondarySchoolRepository $secschoolrep)
    {



        $idiepp=$this->get('session')->get('iepp')->getId();;

        $namestd=$this->get('session')->get('stdname');


        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $studrepo->searchstudentname($idiepp,$namestd,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($studrepo->searchstudentname($idiepp,$namestd, $filters, 0, false)),
            'recordsTotal' => count($studrepo->searchstudentname($idiepp,$namestd, 0, false))
        );

        foreach ($users as $stdn) {


           $studentname=$studrepo->findOneById($stdn['id']);


            $pathmat=  $this->generateUrl('sygdob_editwishstudentname',array('id'=>$stdn['id']))  ;




            $lienmat = '<a href="'.$pathmat.'" class="text-center"><img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" class="rounded-circle" width="30" />'. $stdn['id'].'</a>';








            $nwish1=$secschoolrep->findOneById($studentname->getWish1());

            if(!$nwish1){
                $nawish1="";
            }else{

                $nawish1=$nwish1->getSchoolname();
            }
            $nwish2=$secschoolrep->findOneById($studentname->getWish2());

            if(!$nwish2){
                $nawish2="";
            }else{

                $nawish2=$nwish2->getSchoolname();
            }



            $nwish3=$secschoolrep->findOneById($studentname->getWish3());

            if(!$nwish3){
                $nawish3="";
            }else{

                $nawish3=$nwish3->getSchoolname();
            }

            $output['data'][] = [







                'mat' => $lienmat,
              'first' =>$studentname->getFirstname(),
                'last' => $studentname->getlastname(),
                'birth' => $studentname->getBirthdate()->format('d/m/Y'),
                'place' => $studentname->getPlaceofbirth(),
                'kind' => $studentname->getKind(),
                'nat' => $studentname->getNationality(),
                'resid' => $studentname->getResidence(),
                'wish1' => $nawish1,
                'wish2' => $nawish2,
                'wish3' => $nawish3,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }








    public function editwishstudentname(Request $request, Student $std, IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

        $iepp=$iepprep->findOneById($std->getIepp());
        $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudentType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

            $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


            $kwish1name=$kwish1->getSchoolname();

            $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
                $updbirthdate=0;
            }else{
                $updbirthdate=1;

            }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentname', array('id'=>$std->getId()));






            }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentname', array('id'=>$std->getId()));



            }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudentname', array('id'=>$std->getId()));



            }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('successname', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboardcfiep');




            }















        }


        return  $this->render('cfiep/editwishstudentname.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }




    public function editwishstudenthdname(Request $request, Student $std,  IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep,SecondarySchoolRepository $secscorep)
    {

        $id=$this->get('session')->get('dren')->getId();

        $iepp=$iepprep->findOneById($std->getIepp());
        $school=$primschoolrep->findOneById($std->getSchool());
        $birthdateini=$std->getBirthdate()->format('Y-m-d');




        $request->getSession()->set('idschoolist', $std->getSchool());


        $form= $this->createForm(StudenthdType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {




            $manager= $this->getDoctrine()->getManager();

            $kwish1=$secscorep->findOneById($form['wish1']->getData()->getId());


            $kwish1name=$kwish1->getSchoolname();

            $stdkind=$std->getKind();




            if($form['birthdate']->getData()->format('Y-m-d')==$birthdateini){
                $updbirthdate=0;
            }else{
                $updbirthdate=1;

            }






            $kwish2=$secscorep->findOneById($form['wish2']->getData()->getId());


            $kwish2name=$kwish2->getSchoolname();




            $kwish3=$secscorep->findOneById($form['wish3']->getData()->getId());


            $kwish3name=$kwish3->getSchoolname();





            if ($std->getKind()!= $kwish1->getSchoolkind() && $kwish1->getSchoolkind() != 'MIXTE') {



                $this->addFlash('errorwish1', "L'Etablissement     $kwish1name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdname', array('id'=>$std->getId()));






            }elseif ($std->getKind()!= $kwish2->getSchoolkind() && $kwish2->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish2', "L'Etablissement     $kwish2name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdname', array('id'=>$std->getId()));



            }elseif ($std->getKind()!= $kwish3->getSchoolkind() && $kwish3->getSchoolkind() != 'MIXTE'){




                $this->addFlash('errorwish3', "L'Etablissement     $kwish3name ne reçoit pas des élèves de genre  $stdkind .");
                return $this->redirectToRoute('sygdob_editwishstudenthdname', array('id'=>$std->getId()));



            }else{




                $std->setEntrydate(new \Datetime());
                $std->setEntryuser($this->getUser()->getUsername());
                $std->setUpdatebirthdate($updbirthdate);
                $manager->persist($std);
                $manager->flush();
                $this->addFlash('successname', 'candidat enregistré avec succès');
                return $this->redirectToRoute('sygdob_dashboardcfiep');




            }









        }


        return  $this->render('cfiep/editwishstudenthdname.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }






}
