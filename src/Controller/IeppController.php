<?php

namespace App\Controller;

use App\Entity\PrimarySchool;
use App\Entity\Student;
use App\Form\PrimaryschoolType;
use App\Form\StudentmatType;
use App\Repository\IeppRepository;
use App\Repository\PrimarySchoolRepository;
use App\Repository\SecondarySchoolRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IeppController extends AbstractController
{
    /**
     * Dashboard  IEPP
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardiep()
    {

        $id=$this->get('session')->get('iepp')->getId();

     ;
     


        $primschool= new PrimarySchool();
        $studentmat= new Student();

        $form= $this->createForm(PrimaryschoolType::class, $primschool,array(
            'id' => $id));

        $form2= $this->createForm(StudentmatType::class, $studentmat);



        return $this->render('iepp/dashboardiep.html.twig', [
            'form'=>$form->createView(),'form2'=>$form2->createView()
        ]);
    }




    public function redirecttablestudentbyschooliep(Request $request)
    {

        $tecol=$_POST["primaryschool"];
        $idschoolist=$tecol["schoolname"];
        $request->getSession()->set('idschoolist', $idschoolist);


        return $this->redirectToRoute('sygdob_tablestudentbyschooliep');






    }






    public function tablestudentbyschooliep(Request $request, PrimarySchoolRepository $primschoolrepo, StudentRepository $stdrepo)
    {



        $primschool=$primschoolrepo->findOneById($this->get('session')->get('idschoolist'));


        $searchvalid=$stdrepo->findOneBy(array('school'=>$this->get('session')->get('idschoolist'),'validwish'=>1));

        if(!$searchvalid){
            $validw=0;
        }else{
            $validw=1;
        }

        return  $this->render('iepp/tablestudentbyschooliep.html.twig', array('primschool'=>$primschool,'validw'=>$validw));



    }







    public function listtablestudentbyschooliep(Request $request,StudentRepository $studrepo, SecondarySchoolRepository $secschoolrep)
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










            $lienmat = '<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" class="rounded-circle" width="30" /><span style="color: #0d8bf2">'. $std->getId().'</span>';








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


            if($std->getValidwish()==1){
                $vwish='<i class="fa fa-check-circle alert-success"></i>';
            }else{

                 $vwish="";
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
                'valid' => $vwish,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }





    public function tablerecapwishiep(Request $request)
    {

        $ieppname=$this->get('session')->get('iepp')->getIeppname();



        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentf', 'nbstudentf');

        $sql = "SELECT count(*) as nbstudentf FROM `student`  WHERE  iepp=:iepp and kind='F'   ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('iepp', $this->get('session')->get('iepp')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdf= $nwi['nbstudentf'];

        }




        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentm', 'nbstudentm');

        $sql = "SELECT count(*) as nbstudentm FROM `student`  WHERE  iepp=:iepp and kind='M'   ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('iepp', $this->get('session')->get('iepp')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdm= $nwi['nbstudentm'];

        }


   $nbstd=$nbstdm+$nbstdf;


        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

        $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE  iepp=:iepp and wish1!=''   ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('iepp', $this->get('session')->get('iepp')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdwish= $nwi['nbstudentwish'];

        }




        $taux=number_format(($nbstdwish*100)/$nbstd,2);





        return  $this->render('iepp/tablerecapwishiep.html.twig',array('ieppname'=>$ieppname,'nbstdf'=>$nbstdf,'nbstdm'=>$nbstdm,'nbstd'=>$nbstd,'nbstdwish'=>$nbstdwish,'taux'=>$taux));



    }





    public function tablerecapwishbyschool(Request $request)
    {

        return  $this->render('iepp/tablerecapwishbyschool.html.twig');



    }







    public function listtablerecapwishbyschool(Request $request,PrimarySchoolRepository $primscorep)
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




            $output['data'][] = [







                'school' => $sch->getSchoolname(),
                'std' => $nbstd,
                'stdwish' => $nbstdwish,
                'taux' => $taux,


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }






    public function validwishschool( Request $request)
    {


        $iduser=$this->getUser()->getUsername();






        $sql = " UPDATE student SET valid_wish=1,valid_date=now(),valid_user=:validuser WHERE school=:school and iepp=:iepp  ";
        $params = array('validuser'=>$iduser,'school'=>$this->get('session')->get('idschoolist'),'iepp'=>$this->get('session')->get('iepp')->getId());

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);




        $this->get('session')->getFlashBag()->add(
            'success',
            'Validation effectuée avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tablestudentbyschooliep');


    }



    public function unvalidwishschool( Request $request, IeppRepository $iepprep)
    {






        $sql = " UPDATE student SET valid_wish=null ,valid_date=null,valid_user=null WHERE school=:school and iepp=:iepp  ";
        $params = array('school'=>$this->get('session')->get('idschoolist'),'iepp'=>$this->get('session')->get('iepp')->getId());

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);




        $this->get('session')->getFlashBag()->add(
            'success',
            'Annulation validation effectuée avec succès !!!'
        );

        return $this->redirectToRoute('sygdob_tablestudentbyschooliep');


    }




    public function redirecttablestudentbynameiep(Request $request, StudentRepository $studrepo)
    {

        $stdname=$_POST["stdname"];

        $request->getSession()->set('stdname', $stdname);

        return $this->redirectToRoute('sygdob_tablestudentbynameiep');

    }




    public function tablestudentbynameiep()
    {

        return  $this->render('iepp/tablestudentbynameiep.html.twig');

    }


    public function listtablestudentbynameiep(Request $request,StudentRepository $studrepo, SecondarySchoolRepository $secschoolrep)
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







            $lienmat = '<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" class="rounded-circle" width="30" /><span style="color: #0d8bf2">'. $stdn['id'].'</span>' ;








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





    public function redirecttablestudentbymatiep(Request $request, StudentRepository $studrepo)
    {

        $stdt=$_POST["studentmat"];
        $idstudent=$stdt["id"];
        $cand=$studrepo->findOneById($idstudent);

        if(!$cand){
            $this->addFlash('error', 'Matricule inexistant dans la base des candidats !');
            return $this->redirectToRoute('sygdob_dashboardiep');

        }elseif ($cand->getIepp()!=$this->get('session')->get('iepp')->getId()){


            $this->addFlash('error', 'Ce candidat n\'est pas de votre IEPP !');
            return $this->redirectToRoute('sygdob_dashboardiep');



        }



        else{

            $request->getSession()->set('stdmat', $idstudent);


            return $this->redirectToRoute('sygdob_tablestudentbymatiep');

        }









    }






    public function tablestudentbymatiep()
    {

        return  $this->render('iepp/tablestudentbymatiep.html.twig');

    }


    public function listtablestudentbymatiep(Request $request,StudentRepository $studrepo, SecondarySchoolRepository $secschoolrep)
    {




        $matstd=$this->get('session')->get('stdmat');


        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $searchconsulnotexclass = $request->get('searchstudentschool');
        $filters = [
            'query' => @$searchconsulnotexclass['value']
        ];

        $users = $studrepo->searchstudentmat($matstd,$filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($studrepo->searchstudentmat($matstd, $filters, 0, false)),
            'recordsTotal' => count($studrepo->searchstudentmat($matstd, 0, false))
        );

        foreach ($users as $stdn) {


            $studentname=$studrepo->findOneById($stdn['id']);







            $lienmat = '<img src="/SYGDOB/public/build/content/images/default-avatar.png" alt="user" class="rounded-circle" width="30" /><span style="color: #0d8bf2">'. $stdn['id'].'</span>' ;








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










}
