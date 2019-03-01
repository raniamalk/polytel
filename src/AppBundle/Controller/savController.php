<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\sav;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\savType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class savController extends Controller
{

    public function addAction(Request $request){

        $sav = new sav();

        $form = $this->createForm(savType::class, $sav);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($sav);
            $em->flush();

            return $this->redirect($this->generateUrl('sav_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/savadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:sav');
            $sav = $repository->findAll();

            return $this->render('@App/savlist.html.twig', array('sav'=>$sav));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:sav');
        $sav = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($sav);
        $em->flush();


        return $this->redirect($this->generateUrl('sav_list'));


    }

    public function editAction(Request $request, $id) {
        $sav = new sav();
        $sav = $this->getDoctrine()->getRepository(sav::class)->find($id);
        $form = $this->createForm(savType::class, $sav);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('sav_list');
        }

        return $this->render('@App/savedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function savAction (){

        $repository = $this->getDoctrine()->getRepository('AppBundle:sav');
        $sav = $repository->findAll();

        return $this->render('@App/sav.html.twig', array('sav'=>$sav));

    }



}