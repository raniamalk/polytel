<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\telechargement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\telechargementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class telechargementController extends Controller
{

    public function addAction(Request $request){

        $telechargement = new telechargement();

        $form = $this->createForm(telechargementType::class, $telechargement);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('telechargement')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $telechargement->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $telechargement->upload();
            $em->persist($telechargement);
            $em->flush();

            return $this->redirect($this->generateUrl('telechargement_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/telechargementadd.html.twig', array('form'=>$formView));

    }


    public function listAction (){

            $repository = $this->getDoctrine()->getRepository('AppBundle:telechargement');
            $telechargement = $repository->findAll();

            return $this->render('@App/telechargementlist.html.twig', array('telechargement'=>$telechargement));

    }


    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:telechargement');
        $telechargement = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($telechargement);
        $em->flush();


        return $this->redirect($this->generateUrl('telechargement_list'));


    }

    public function editAction(Request $request, $id) {
        $telechargement = new telechargement();
        $telechargement = $this->getDoctrine()->getRepository(telechargement::class)->find($id);
        $form = $this->createForm(telechargementType::class, $telechargement);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('telechargement')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $telechargement->setPath($filename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $telechargement->upload();
            $entityManager->flush();
            return $this->redirectToRoute('telechargement_list');
        }

        return $this->render('@App/telechargementedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function telechargementAction (){

        $repository = $this->getDoctrine()->getRepository('AppBundle:telechargement');
        $telechargement = $repository->findAll();

        return $this->render('@App/telechargement.html.twig', array('telechargement'=>$telechargement));

    }


}
