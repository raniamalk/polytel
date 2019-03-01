<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\tarif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\tarifType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class tarifController extends Controller
{

    public function addAction(Request $request){

        $tarif = new tarif();

        $form = $this->createForm(tarifType::class, $tarif);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('tarif')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $tarif->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $tarif->upload();
            $em->persist($tarif);
            $em->flush();

            return $this->redirect($this->generateUrl('tarif_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/tarifadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:tarif');
            $tarif = $repository->findAll();

            return $this->render('@App/tariflist.html.twig', array('tarif'=>$tarif));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:tarif');
        $tarif = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($tarif);
        $em->flush();


        return $this->redirect($this->generateUrl('tarif_list'));


    }

    public function editAction(Request $request, $id) {
        $tarif = new tarif();
        $tarif = $this->getDoctrine()->getRepository(tarif::class)->find($id);
        $form = $this->createForm(tarifType::class, $tarif);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('tarif')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $tarif->setPath($filename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $tarif->upload();
            $entityManager->flush();
            return $this->redirectToRoute('tarif_list');
        }

        return $this->render('@App/tarifedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function tarifAction (){

        $repository = $this->getDoctrine()->getRepository('AppBundle:tarif');
        $tarif = $repository->findAll();

        return $this->render('@App/tarif.html.twig', array('tarif'=>$tarif));

    }


}