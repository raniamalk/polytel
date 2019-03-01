<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\cgv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\cgvType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class cgvController extends Controller
{

    public function addAction(Request $request){

        $cgv = new cgv();

        $form = $this->createForm(cgvType::class, $cgv);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($cgv);
            $em->flush();

            return $this->redirect($this->generateUrl('cgv_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/cgvadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:cgv');
            $cgv = $repository->findAll();

            return $this->render('@App/cgvlist.html.twig', array('cgv'=>$cgv));


    }

    public function editAction(Request $request, $id) {
        $cgv = new cgv();
        $cgv = $this->getDoctrine()->getRepository(cgv::class)->find($id);
        $form = $this->createForm(cgvType::class, $cgv);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('cgv_list');
        }

        return $this->render('@App/cgvedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function cgvAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:cgv');
        $cgv = $repository->findAll();

        return $this->render('@App/cgv.html.twig', array('cgv'=>$cgv));


    }


}