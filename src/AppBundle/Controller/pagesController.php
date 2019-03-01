<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\pagesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class pagesController extends Controller
{

    public function addAction(Request $request){

        $pages = new pages();

        $form = $this->createForm(pagesType::class, $pages);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('pages')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $pages->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $pages->upload();
            $em->persist($pages);
            $em->flush();

            return $this->redirect($this->generateUrl('pages_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/pagesadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:pages');
            $pages = $repository->findAll();

            return $this->render('@App/pageslist.html.twig', array('pages'=>$pages));


    }

    public function editAction(Request $request, $id) {
        $pages = new pages();
        $pages = $this->getDoctrine()->getRepository(pages::class)->find($id);
        $form = $this->createForm(pagesType::class, $pages);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('pages')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            if ($file != null){
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $pages->setPath($filename);}

            $entityManager = $this->getDoctrine()->getManager();
            $pages->upload();
            $entityManager->flush();
            return $this->redirectToRoute('pages_list');
        }

        return $this->render('@App/pagesedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:pages');
        $pages = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($pages);
        $em->flush();


        return $this->redirect($this->generateUrl('pages_list'));


    }


    public function pagesAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:pages');
        $pages = $repository->findAll();

        return $this->render('@App/pages.html.twig', array('pages'=>$pages));

    }


}