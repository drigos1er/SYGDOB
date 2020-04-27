<?php

namespace App\Controller;

use App\Entity\PrimarySchool;
use App\Form\PrimaryschoolType;
use App\Repository\PrimarySchoolRepository;
use App\Repository\SecondarySchoolRepository;
use App\Repository\StudentRepository;
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


        $primschool= new PrimarySchool();

        $form= $this->createForm(PrimaryschoolType::class, $primschool,array(
            'id' => $id));




        return $this->render('iepp/dashboardiep.html.twig', [
            'form'=>$form->createView()
        ]);
    }




    public function redirecttablestudentbyschooliep(Request $request)
    {

        $tecol=$_POST["primaryschool"];
        $idschoolist=$tecol["schoolname"];
        $request->getSession()->set('idschoolist', $idschoolist);


        return $this->redirectToRoute('sygdob_tablestudentbyschooliep');






    }






    public function tablestudentbyschooliep(Request $request, PrimarySchoolRepository $primschoolrepo)
    {



        $primschool=$primschoolrepo->findOneById($this->get('session')->get('idschoolist'));



        return  $this->render('iepp/tablestudentbyschooliep.html.twig', array('primschool'=>$primschool));



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
                'valid' => '',


            ];

















        }























        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);




    }








}
