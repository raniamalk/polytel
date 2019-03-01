<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\devis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\devisType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class devisController extends Controller
{

    public function addAction(Request $request){

        $devis = new devis();

        $devis->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(devisType::class, $devis);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($devis);
            $em->flush();

            return $this->redirect($this->generateUrl('devis_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/devisadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:devis');
            $devis = $repository->findAll();

            return $this->render('@App/devislist.html.twig', array('devis'=>$devis));


    }

    public function editAction(Request $request, $id) {
        $devis = new devis();
        $devis = $this->getDoctrine()->getRepository(devis::class)->find($id);
        $form = $this->createForm(devisType::class, $devis);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('devis_list');
        }

        return $this->render('@App/devisedit.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:devis');
        $devis = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($devis);
        $em->flush();


        return $this->redirect($this->generateUrl('devis_list'));


    }



}