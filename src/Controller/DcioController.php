<?php

namespace App\Controller;

use App\Repository\IeppRepository;
use App\Repository\PrimarySchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;

class DcioController extends AbstractController
{
    /**
     * Dashboard  DCIO
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboarddcio()
    {

        return $this->render('dcio/dashboarddcio.html.twig');
    }



    public function tablerecapwishcio(Request $request)
    {

        $drenname=$this->get('session')->get('dren')->getDrenname();



        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentf', 'nbstudentf');

        $sql = "SELECT count(*) as nbstudentf FROM `student`  WHERE   kind='F'  and dren=:dren  ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('dren', $this->get('session')->get('dren')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdf= $nwi['nbstudentf'];

        }




        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentm', 'nbstudentm');

        $sql = "SELECT count(*) as nbstudentm FROM `student`  WHERE   kind='M' and dren=:dren    ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('dren', $this->get('session')->get('dren')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdm= $nwi['nbstudentm'];

        }


        $nbstd=$nbstdm+$nbstdf;


        $em = $this->getDoctrine()->getManager();


        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('nbstudentwish', 'nbstudentwish');

        $sql = "SELECT count(*) as nbstudentwish FROM `student`  WHERE   wish1!=''  and dren=:dren ";
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter('dren', $this->get('session')->get('dren')->getId());

        $averw= $query->getResult();


        foreach ($averw as $nwi) {
            $nbstdwish= $nwi['nbstudentwish'];

        }




        $taux=number_format(($nbstdwish*100)/$nbstd,2);





        return  $this->render('dcio/tablerecapwishcio.html.twig',array('drenname'=>$drenname,'nbstdf'=>$nbstdf,'nbstdm'=>$nbstdm,'nbstd'=>$nbstd,'nbstdwish'=>$nbstdwish,'taux'=>$taux));



    }



    public function tablerecapwishbyiep(Request $request)
    {

        return  $this->render('dcio/tablerecapwishbyiep.html.twig');



    }







    public function listtablerecapwishbyiep(Request $request,IeppRepository $iepprepo)
    {



        $iddren=$this->get('session')->get('dren')->getId();




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


            $pathmat=  $this->generateUrl('sygdob_redirecttablerecapwishbyschoolcio',array('iepp'=>$sch->getId()))  ;




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




    public function redirecttablerecapwishbyschoolcio(Request $request, IeppRepository $iepprepo)
    {



        $ieppbyschool=$iepprepo->findOneById($request->query->get('iepp'));



        $request->getSession()->set('idiepp', $request->query->get('iepp'));

        $request->getSession()->set('ieppnamebyschool', $ieppbyschool->getIeppname());
        return $this->redirectToRoute('sygdob_tablerecapwishbyschoolcio');






    }





    public function tablerecapwishbyschoolcio(Request $request)
    {

        return  $this->render('dcio/tablerecapwishbyschoolcio.html.twig');



    }







    public function listtablerecapwishbyschoolcio(Request $request,PrimarySchoolRepository $primscorep)
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








}
