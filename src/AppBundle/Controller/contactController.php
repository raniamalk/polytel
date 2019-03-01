<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\contactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class contactController extends Controller
{

    public function addAction(Request $request){

        $contact = new contact();

        $contact->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(contactType::class, $contact);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            return $this->redirect($this->generateUrl('contact_add'));
        }

        $formView=$form->createView();

        return $this->render('@App/contactadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:contact');
            $contact = $repository->findAll();

            return $this->render('@App/contactlist.html.twig', array('contact'=>$contact));


    }

    public function editAction(Request $request, $id) {
        $contact = new contact();
        $contact = $this->getDoctrine()->getRepository(contact::class)->find($id);
        $form = $this->createForm(contactType::class, $contact);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('contact_list');
        }

        return $this->render('@App/contactedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:contact');
        $contact = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();


        return $this->redirect($this->generateUrl('contact_list'));


    }



}