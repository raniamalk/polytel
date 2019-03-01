<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\motpresident;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\motpresidentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class motpresidentController extends Controller
{

    public function addAction(Request $request){

        $motpresident = new motpresident();
        $form = $this->createForm(motpresidentType::class, $motpresident);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($motpresident);
            $em->flush();

            return $this->redirect($this->generateUrl('motpresident_add'));
        }

        $formView=$form->createView();

        return $this->render('@App/motpresidentadd.html.twig', array('form'=>$formView));

    }

    public function listAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:motpresident');
        $motpresident = $repository->findAll();

        return $this->render('@App/motpresidentlist.html.twig', array('motpresident'=>$motpresident));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:motpresident');
        $motpresident = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($motpresident);
        $em->flush();


        return $this->redirect($this->generateUrl('motpresident_list'));


    }


    public function editAction(Request $request, $id) {
        $motpresident = new motpresident();
        $motpresident = $this->getDoctrine()->getRepository(motpresident::class)->find($id);
        $form = $this->createForm(motpresidentType::class, $motpresident);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('motpresident_list');
        }

        return $this->render('@App/motpresidentedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function motpresidentAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:motpresident');
        $motpresident = $repository->findAll();

        return $this->render('@App/motpresident.html.twig', array('motpresident'=>$motpresident));


    }

}