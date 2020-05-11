<?php

namespace App\Controller;

use App\Entity\Drenddn;
use App\Entity\Iepp;
use App\Entity\SygdobUser;
use App\Form\DrenddnType;
use App\Form\IeppType;
use App\Form\UsermatType;
use App\Form\UserstructureType;
use App\Repository\DrenddnRepository;
use App\Repository\IeppRepository;
use App\Repository\PrimarySchoolRepository;
use App\Repository\SygdobRoleRepository;
use App\Repository\SygdobUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;

class DobinfoController extends AbstractController
{
    /**
     * Dashboard  DOBINFO
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboarddobinfo()
    {

        return $this->render('dobinfo/dashboarddobinfo.html.twig');
    }




    public function tablerecapwishdobinfo(Request $request)
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





        return  $this->render('dobinfo/tablerecapwishdobinfo.html.twig',array('nbstdf'=>$nbstdf,'nbstdm'=>$nbstdm,'nbstd'=>$nbstd,'nbstdwish'=>$nbstdwish,'taux'=>$taux));



    }




    public function tablerecapwishbydren(Request $request)
    {

        return  $this->render('dobinfo/tablerecapwishbydren.html.twig');



    }







    public function listtablerecapwishbydren(Request $request,DrenddnRepository $drenrepo)
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


            $pathmat=  $this->generateUrl('sygdob_redirecttablerecapwishbyiepdob',array('dren'=>$sch->getId()))  ;




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



    public function redirecttablerecapwishbyiepdob(Request $request, DrenddnRepository $drenddnrepo)
    {


        $drenddnbyiep=$drenddnrepo->findOneById($request->query->get('dren'));

        $request->getSession()->set('iddren', $request->query->get('dren'));


        $request->getSession()->set('drenddnnamebyiep', $drenddnbyiep->getDrenname());
        return $this->redirectToRoute('sygdob_tablerecapwishbyiepdob');






    }




    public function tablerecapwishbyiepdob(Request $request)
    {

        return  $this->render('dobinfo/tablerecapwishbyiepdob.html.twig');



    }







    public function listtablerecapwishbyiepdob(Request $request,IeppRepository $iepprepo)
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


            $pathmat=  $this->generateUrl('sygdob_redirecttablerecapwishbyschooldob',array('iepp'=>$sch->getId()))  ;




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




    public function redirecttablerecapwishbyschooldob(Request $request, IeppRepository $iepprep)
    {




        $ieppbyschooldob=$iepprep->findOneById($request->query->get('iepp'));
        $request->getSession()->set('idiepp', $request->query->get('iepp'));

        $request->getSession()->set('ieppnamebyschooldob', $ieppbyschooldob->getIeppname());
        return $this->redirectToRoute('sygdob_tablerecapwishbyschooldob');






    }





    public function tablerecapwishbyschooldob(Request $request)
    {

        return  $this->render('dobinfo/tablerecapwishbyschooldob.html.twig');



    }







    public function listtablerecapwishbyschooldob(Request $request,PrimarySchoolRepository $primscorep)
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

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewuserdob(Request $request, SygdobUserRepository $sygdobuserrepo,SygdobRoleRepository $sygrolerep, IeppRepository $iepprep)
    {






        $form= $this->createForm(UsermatType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

           $syguser=$sygdobuserrepo->findOneByUsername($form['username']->getData());


            if(!$syguser){
                $this->addFlash('error', 'Utilisateur inexistant  !');
                return $this->redirectToRoute('sygdob_viewuserdob');

            }





            $userole=$sygrolerep->findOneById($syguser->getUserrole());





            $useriep=$iepprep->findOneById($syguser->getUserstructure()->getId());


            if($syguser->getUserrole() =='1') {

                $request->getSession()->set('syguser', $syguser);
                $request->getSession()->set('userole', $userole);
                $request->getSession()->set('useriep', $useriep);

                return $this->redirectToRoute('sygdob_tableviewuserdob');

            }
            elseif($syguser->getUserrole() =='2'){


                $request->getSession()->set('syguser', $syguser);
                $request->getSession()->set('userole', $userole);
                $request->getSession()->set('useriep', $useriep);

                return $this->redirectToRoute('sygdob_tableviewuserdob');

            }



            else{







                $this->addFlash('error', 'Vous n\'êtes pas autorisé à gérer cet utilisateur  !');
                return $this->redirectToRoute('sygdob_viewuserdob');

            }










        }


        return $this->render('dobinfo/viewuserdob.html.twig', [
            'form'=>$form->createView()
        ]);
    }




    public function tableviewuserdob(Request $request, SygdobUserRepository $syguserrepo)
    {

        $userpro=$syguserrepo->findOneByUsername($this->get('session')->get('syguser')->getUsername());

        return  $this->render('dobinfo/tableviewuserdob.html.twig',array('userpro'=>$userpro));



    }



    public function deactivateuserdob( Request $request)
    {









        $sql = " UPDATE sygdob_user SET enabled=0 WHERE username=:username   ";
        $params = array('username'=>$this->get('session')->get('syguser')->getUsername());

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);


        if ($this->get('session')->get('userrole')=='ROLE_ADMINDOB') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte désactivé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }








        if ($this->get('session')->get('userrole')=='ROLE_DOBINFO') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte désactivé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdob');

        }






    }



    public function activateuserdob( Request $request)
    {









        $sql = " UPDATE sygdob_user SET enabled=1 WHERE username=:username   ";
        $params = array('username'=>$this->get('session')->get('syguser')->getUsername());

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);





        if ($this->get('session')->get('userrole')=='ROLE_ADMINDOB') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte activé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }








        if ($this->get('session')->get('userrole')=='ROLE_DOBINFO') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte activé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdob');

        }


    }



    public function resetuserdob( Request $request)
    {


   $pwd='$2y$13$SbQbBqins5p2aAhynnf5De3IyLgEP5uY./zndm5oG.g.rPlmgEhK.';






        $sql = " UPDATE sygdob_user SET enabled=1, password=:password WHERE username=:username   ";
        $params = array('username'=>$this->get('session')->get('syguser')->getUsername(),'password'=>$pwd);

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);





        if ($this->get('session')->get('userrole')=='ROLE_ADMINDOB') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte réinitialisé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdobadm');

        }








        if ($this->get('session')->get('userrole')=='ROLE_DOBINFO') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte réinitialisé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_tableviewuserdob');

        }


    }



    public function deleteuserdob( Request $request)
    {



        $sql = " DELETE FROM sygdob_user  WHERE username=:username   ";
        $params = array('username'=>$this->get('session')->get('syguser')->getUsername());

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);





        if ($this->get('session')->get('userrole')=='ROLE_ADMINDOB') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte supprimé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_usermanagmt');

        }








        if ($this->get('session')->get('userrole')=='ROLE_DOBINFO') {

            $this->get('session')->getFlashBag()->add(
                'success',
                'Compte supprimé  avec succès !!!'
            );

            return $this->redirectToRoute('sygdob_viewuserdob');

        }


    }



    public function usermanagmtdobinfo()
    {

        $iep= new Iepp();


        $form= $this->createForm(IeppType::class, $iep);




        return $this->render('dobinfo/viewuserdob.html.twig', [
            'form'=>$form->createView(),
        ]);
    }



    public function redirecttableuserbyiepdobinfo(Request $request)
    {

        $tecol=$_POST["iepp"];
        $idiepp=$tecol["ieppname"];
        $request->getSession()->set('idiepp', $idiepp);


        return $this->redirectToRoute('sygdob_tableuserbyiepdobinfo');






    }





    public function tableuserbyiepdobinfo(Request $request, IeppRepository $iepprepo)
    {



        $iepp=$iepprepo->findOneById($this->get('session')->get('idiepp'));



        return  $this->render('dobinfo/tableuserbyiepdobinfo.html.twig', array('iepp'=>$iepp));



    }







    public function listtableuserbyiepdobinfo(Request $request,SygdobUserRepository $syguserrep)
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

                $tof='     <img src="/SYGDOB/public/images/users/'.$pictureusr.'" alt="user" width="30" class="profile-pic rounded-circle" />' ;
            }




            if($usr->getEnabled()==1){







                $pathstatus=  $this->generateUrl('sygdob_deactivateuserdobiepdobinfo',array('login'=>$usr->getUsername()));



                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-success text-center" title="Cliquer pour désactiver le compte"><i class="mdi mdi-account-check "></i></a>';



            }else{


                $pathstatus=  $this->generateUrl('sygdob_activateuserdobiepdobinfo',array('login'=>$usr->getUsername()));

                $lienstatus = '<a href="'.$pathstatus.'" type="button" class="btn waves-effect waves-light btn-danger text-center" title="Cliquer pour activer le compte"><i class="mdi mdi-account-off "></i></a>';


            }


            $pathreset=  $this->generateUrl('sygdob_resetuserdobiepdobinfo',array('login'=>$usr->getUsername()));
            $lienreset = '<a href="'.$pathreset.'" type="button" class="btn waves-effect waves-light btn-warning text-center" title="Cliquer pour réinitialiser le compte"><i class="mdi mdi-account-convert "></i></a>';


            $pathremove=  $this->generateUrl('sygdob_alertdeleteuseriepdobinfo',array('login'=>$usr->getUsername(),'id'=>$usr->getId()));

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





    public function deactivateuserdobiepdobinfo( Request $request)
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

        return $this->redirectToRoute('sygdob_tableuserbyiepdobinfo');














    }



    public function activateuserdobiepdobinfo( Request $request)
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

        return $this->redirectToRoute('sygdob_tableuserbyiepdobinfo');










    }



    public function resetuserdobiepdobinfo( Request $request)
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

        return $this->redirectToRoute('sygdob_tableuserbyiepdobinfo');










    }




    public function alertedeleteuseriepdobinfo(Request $request)
    {



        return  $this->render('dobinfo/alertdeleteuseriepdobinfo.html.twig',array('login'=>$request->query->get('login'),'id'=>$request->query->get('id')));



    }





    public function deleteuserdobiepdobinfo( Request $request)
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

        return $this->redirectToRoute('sygdob_tableuserbyiepdobinfo');












    }



}
