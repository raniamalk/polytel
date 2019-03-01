<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\marque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\marqueType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class marqueController extends Controller
{

    public function addAction(Request $request){

        $marque = new marque();

        $form = $this->createForm(marqueType::class, $marque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('marque')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $marque->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $marque->upload();
            $em->persist($marque);
            $em->flush();

            return $this->redirect($this->generateUrl('marque_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/marqueadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
            $marque = $repository->findAll();

            return $this->render('@App/marquelist.html.twig', array('marque'=>$marque));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
        $marque = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($marque);
        $em->flush();


        return $this->redirect($this->generateUrl('marque_list'));


    }

    public function editAction(Request $request, $id) {
        $marque = new marque();
        $marque = $this->getDoctrine()->getRepository(marque::class)->find($id);
        $form = $this->createForm(marqueType::class, $marque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('marque')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $marque->setPath($filename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $marque->upload();
            $entityManager->flush();
            return $this->redirectToRoute('marque_list');
        }

        return $this->render('@App/marqueedit.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function marqueAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
        $marque = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('AppBundle:textmarque');
        $textmarque = $repository->findAll();

        return $this->render('@App/nosmarques.html.twig', array('marque'=>$marque, 'textmarque'=>$textmarque));


    }



}