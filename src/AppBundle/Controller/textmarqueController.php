<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\textmarque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\textmarqueType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class textmarqueController extends Controller
{

    public function addAction(Request $request){

        $textmarque = new textmarque();

        $form = $this->createForm(textmarqueType::class, $textmarque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($textmarque);
            $em->flush();

            return $this->redirect($this->generateUrl('textmarque_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/textmarqueadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:textmarque');
            $textmarque = $repository->findAll();

            return $this->render('@App/textmarquelist.html.twig', array('textmarque'=>$textmarque));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:textmarque');
        $textmarque = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($textmarque);
        $em->flush();


        return $this->redirect($this->generateUrl('textmarque_list'));


    }

    public function editAction(Request $request, $id) {
        $textmarque = new textmarque();
        $textmarque = $this->getDoctrine()->getRepository(textmarque::class)->find($id);
        $form = $this->createForm(textmarqueType::class, $textmarque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('textmarque_list');
        }

        return $this->render('@App/textmarqueedit.html.twig', array(
            'form' => $form->createView()
        ));
    }




}