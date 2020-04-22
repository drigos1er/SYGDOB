<?php

namespace App\Controller;

use App\Entity\PrimarySchool;
use App\Entity\Student;
use App\Form\PrimaryschoolType;
use App\Form\StudentType;
use App\Repository\IeppRepository;
use App\Repository\PrimarySchoolRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $form= $this->createForm(PrimaryschoolType::class, $primschool,array(
            'id' => $id));




        return $this->render('cfiep/dashboardcfiep.html.twig', [
            'form'=>$form->createView()
        ]);
    }


    public function tablestudentbyschoolcf(Request $request, PrimarySchoolRepository $primschoolrepo)
    {

             $tecol=$_POST["primaryschool"];
            $idschoolist=$tecol["schoolname"];
        $request->getSession()->set('idschoolist', $idschoolist);

        $primschool=$primschoolrepo->findOneById($idschoolist);



        return  $this->render('cfiep/tablestudentbyschoolcf.html.twig', array('primschool'=>$primschool));



    }


    public function listtablestudentbyschoolcf(Request $request,StudentRepository $studrepo)
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


            $lienmat = '<a href="'.$pathmat.'">'.$std->getId().' </a>';




            $output['data'][] = [







               'mat' => $lienmat,
                'first' => $std->getFirstname(),
                'last' => $std->getLastname(),
                'birth' => $std->getBirthdate()->format('d/m/Y'),
                'place' => $std->getPlaceofbirth(),
                'kind' => $std->getKind(),
                'nat' => $std->getNationality(),
                'resid' => $std->getResidence(),
                'wish1' => $std->getWish1(),
                'wish2' => $std->getWish2(),
                'wish3' => $std->getWish3(),


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }




    public function editwishstudent(Request $request, Student $std, StudentRepository $studrepo, IeppRepository $iepprep, PrimarySchoolRepository $primschoolrep)
    {

        $id=$this->get('session')->get('dren')->getId();

         $iepp=$iepprep->findOneById($std->getIepp());
         $school=$primschoolrep->findOneById($std->getSchool());


        $form= $this->createForm(StudentType::class, $std,array(
            'id' => $id));



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {



            $manager= $this->getDoctrine()->getManager();





                $manager->persist($std);
                $manager->flush();
                $this->addFlash('success', 'candidat enregistré avec succès');
            return $this->redirectToRoute('sygdob_tablestudentbyschoolcf');












             }


        return  $this->render('cfiep/editwishstudent.html.twig', array('std'=>$std,'form'=>$form->createView(),'iepp'=>$iepp,'school'=>$school));
    }



}
