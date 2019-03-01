<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\newsletterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;



class newsletterController extends Controller
{

    public function addAction(Request $request){

        $newsletter = new newsletter();

        $form = $this->createForm(newsletterType::class, $newsletter);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($newsletter);
            $em->flush();

            /*return $this->redirect($this->generateUrl('newsletter_list'));*/
            /*return $this->templatingEngine->renderResponse('@SyliusShop/Homepage/index.html.twig');*/
            return $this->redirect($this->generateUrl('sylius_shop_homepage'));

        }

        $formView=$form->createView();

        return $this->render('@App/newsletteradd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:newsletter');
            $newsletter = $repository->findAll();

            return $this->render('@App/newsletterlist.html.twig', array('newsletter'=>$newsletter));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:newsletter');
        $newsletter = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($newsletter);
        $em->flush();


        return $this->redirect($this->generateUrl('newsletter_list'));


    }

    public function editAction(Request $request, $id) {
        $newsletter = new newsletter();
        $newsletter = $this->getDoctrine()->getRepository(newsletter::class)->find($id);
        $form = $this->createForm(newsletterType::class, $newsletter);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('newsletter_list');
        }

        return $this->render('@App/newsletteredit.html.twig', array(
            'form' => $form->createView()
        ));
    }



}