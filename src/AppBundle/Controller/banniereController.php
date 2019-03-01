<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\banniere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\banniereType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class banniereController extends Controller
{

    public function addAction(Request $request){

        $banniere = new banniere();

        $form = $this->createForm(banniereType::class, $banniere);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('banniere')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $banniere->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $banniere->upload();
            $em->persist($banniere);
            $em->flush();

            return $this->redirect($this->generateUrl('banniere_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/banniereadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:banniere');
            $banniere = $repository->findAll();

            return $this->render('@App/bannierelist.html.twig', array('banniere'=>$banniere));


    }
    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:banniere');
        $banniere = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($banniere);
        $em->flush();


        return $this->redirect($this->generateUrl('banniere_list'));


    }


    public function editAction(Request $request, $id) {
        $banniere = new banniere();
        $banniere = $this->getDoctrine()->getRepository(banniere::class)->find($id);
        $form = $this->createForm(banniereType::class, $banniere);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('banniere')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $banniere->setPath($filename);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $banniere->upload();
            $entityManager->flush();
            return $this->redirectToRoute('banniere_list');
        }

        return $this->render('@App/banniereedit.html.twig', array(
            'form' => $form->createView()
        ));
    }


}