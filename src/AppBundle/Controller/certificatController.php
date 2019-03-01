<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\certificat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\certificatType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class certificatController extends Controller
{

    public function addAction(Request $request){

        $certificat = new certificat();

        $form = $this->createForm(certificatType::class, $certificat);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('certificat')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $certificat->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $certificat->upload();
            $em->persist($certificat);
            $em->flush();

            return $this->redirect($this->generateUrl('certificat_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/certificatadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:certificat');
            $certificat = $repository->findAll();

            return $this->render('@App/certificatlist.html.twig', array('certificat'=>$certificat));


    }

    public function editAction(Request $request, $id) {
        $certificat = new certificat();
        $certificat = $this->getDoctrine()->getRepository(certificat::class)->find($id);
        $form = $this->createForm(certificatType::class, $certificat);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('certificat')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            if ($file != null){
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $certificat->setPath($filename);}

            $entityManager = $this->getDoctrine()->getManager();
            $certificat->upload();
            $entityManager->flush();
            return $this->redirectToRoute('certificat_list');
        }

        return $this->render('@App/certificatedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:certificat');
        $certificat = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($certificat);
        $em->flush();


        return $this->redirect($this->generateUrl('certificat_list'));


    }


    public function certificatAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:certificat');
        $certificat = $repository->findAll();

        return $this->render('@App/certificat.html.twig', array('certificat'=>$certificat));

    }


}