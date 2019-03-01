<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\slider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\sliderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class sliderController extends Controller
{

    public function addAction(Request $request){

        $slider = new slider();

        $form = $this->createForm(sliderType::class, $slider);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('slider')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $slider->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $slider->upload();
            $em->persist($slider);
            $em->flush();

            return $this->redirect($this->generateUrl('slider_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/slideradd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:slider');
            $slider = $repository->findAll();

            return $this->render('@App/sliderlist.html.twig', array('slider'=>$slider));


    }
    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:slider');
        $slider = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($slider);
        $em->flush();


        return $this->redirect($this->generateUrl('slider_list'));


    }


    public function editAction(Request $request, $id) {
        $slider = new slider();
        $slider = $this->getDoctrine()->getRepository(slider::class)->find($id);
        $form = $this->createForm(sliderType::class, $slider);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('slider')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($uploads_directory, $filename );
                $slider->setPath($filename);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $slider->upload();
            $entityManager->flush();
            return $this->redirectToRoute('slider_list');
        }

        return $this->render('@App/slideredit.html.twig', array(
            'form' => $form->createView()
        ));
    }


}