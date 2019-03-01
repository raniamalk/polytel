<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\infocontact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\infocontactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class infocontactController extends Controller
{

    public function addAction(Request $request){

        $infocontact = new infocontact();
        /*$form = $this->createForm(new infocontactType(), $infocontact);*/
        $form = $this->createForm(infocontactType::class, $infocontact);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('infocontact')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $infocontact->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $infocontact->upload();
            $em->persist($infocontact);
            $em->flush();

            return $this->redirect($this->generateUrl('infocontact_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/test.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:infocontact');
            $infocontact = $repository->findAll();

            return $this->render('@App/infocontactlist.html.twig', array('infocontact'=>$infocontact));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:infocontact');
        $infocontact = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($infocontact);
        $em->flush();


        return $this->redirect($this->generateUrl('infocontact_list'));


    }

    public function editAction(Request $request, $id) {
        $infocontact = new infocontact();
        $infocontact = $this->getDoctrine()->getRepository(infocontact::class)->find($id);
        $form = $this->createForm(infocontactType::class, $infocontact);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('infocontact')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $infocontact->setPath($filename);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $infocontact->upload();
            $entityManager->flush();
            return $this->redirectToRoute('infocontact_list');
        }

        return $this->render('@App/infocontactedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}