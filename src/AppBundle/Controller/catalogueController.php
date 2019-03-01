<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\catalogue;
use AppBundle\Entity\pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\catalogueType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class catalogueController extends Controller
{

    public function addAction(Request $request){

        $catalogue = new catalogue();

        $form = $this->createForm(catalogueType::class, $catalogue);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('catalogue')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $catalogue->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $catalogue->upload();

            $em->persist($catalogue);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogue_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/catalogueadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:catalogue');
            $catalogue = $repository->findAll();

            return $this->render('@App/cataloguelist.html.twig', array('catalogue'=>$catalogue));


    }

    public function editAction(Request $request, $id) {
        $catalogue = new catalogue();
        $catalogue = $this->getDoctrine()->getRepository(catalogue::class)->find($id);
        $form = $this->createForm(catalogueType::class, $catalogue);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('catalogue')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            if ($file != null){
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $catalogue->setPath($filename);}

            $entityManager = $this->getDoctrine()->getManager();
            $catalogue->upload();
            $entityManager->flush();
            return $this->redirectToRoute('catalogue_list');
        }

        return $this->render('@App/catalogueedit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:catalogue');
        $catalogue = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($catalogue);
        $em->flush();


        return $this->redirect($this->generateUrl('catalogue_list'));


    }


    public function catalogueAction (){


        $repository = $this->getDoctrine()->getRepository('AppBundle:catalogue');
        $catalogue = $repository->findAll();

        return $this->render('@App/catalogue.html.twig', array('catalogue'=>$catalogue));

    }


    public function cataloguepageAction ($id){


        $repository = $this->getDoctrine()->getRepository('AppBundle:catalogue');
        $catalogue = $repository->find($id);

        $repository = $this->getDoctrine()->getRepository('AppBundle:pages');
        /*$pages = $repository->findBy(array('catalogue_id' => $id));*/
        $pages = $repository->findBy(['catalogue' => $id], ['position' => 'ASC']);

        /*$qb = $this->createQueryBuilder('c')
            ->where('c.catalogue = :catalogue_id')
            ->setParameter('catalogue_id', $catalogue->getId());
        $query = $qb->getQuery();
        return $query->execute();*/

        return $this->render('@App/cataloguepage.html.twig', array('catalogue'=>$catalogue, 'pages'=>$pages));

    }


}