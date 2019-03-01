<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\presentation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\presentationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class presentationController extends Controller
{

    public function addAction(Request $request){

        $presentation = new presentation();

        $form = $this->createForm(presentationType::class, $presentation);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('presentation')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $presentation->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $presentation->upload();

            $em->persist($presentation);
            $em->flush();

            return $this->redirect($this->generateUrl('presentation_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/presentationadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:presentation');
            $presentation = $repository->findAll();

            return $this->render('@App/presentationlist.html.twig', array('presentation'=>$presentation));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:presentation');
        $presentation = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($presentation);
        $em->flush();


        return $this->redirect($this->generateUrl('presentation_list'));


    }

    public function editAction(Request $request, $id) {
        $presentation = new presentation();
        $presentation = $this->getDoctrine()->getRepository(presentation::class)->find($id);
        $form = $this->createForm(presentationType::class, $presentation);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('presentation')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $presentation->setPath($filename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $presentation->upload();
            $entityManager->flush();
            return $this->redirectToRoute('presentation_list');
        }

        return $this->render('@App/presentationedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function presentationAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:presentation');
        $presentation = $repository->findAll();

        return $this->render('@App/presentation.html.twig', array('presentation'=>$presentation));


    }



}