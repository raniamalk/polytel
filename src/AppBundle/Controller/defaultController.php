<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 24/12/2018
 * Time: 13:50
 */

namespace AppBundle\Controller;


use AppBundle\Entity\infocontact;
use AppBundle\Entity\slider;
use AppBundle\Entity\presentation;
use AppBundle\Entity\newsletter;
use AppBundle\Entity\telechargement;
use AppBundle\Entity\cgv;
use AppBundle\Entity\marque;
use AppBundle\Entity\textmarque;
use AppBundle\Entity\contact;
use AppBundle\Entity\certificat;
use AppBundle\Entity\tarif;
use AppBundle\Entity\sav;
use AppBundle\Entity\motpresident;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class defaultController extends Controller
{

    public function infocontactAction()
    {

        $repository = $this->getDoctrine()->getRepository(infocontact::class);

        $infocontact = $repository->findAll();
        return $this->render('@App/infocontact.html.twig', array('infocontact'=>$infocontact));
    }

    public function sliderAction()
    {

        $repository = $this->getDoctrine()->getRepository(slider::class);

        $slider = $repository->findAll();
        return $this->render('@App/slider.html.twig', array('slider'=>$slider));
    }

    public function presentationAction()
    {

        $repository = $this->getDoctrine()->getRepository(presentation::class);

        $presentation = $repository->findAll();
        return $this->render('@App/newsletter.html.twig', array('newsletter'=>$presentation));
    }

    public function newsletterAction()
    {

        $repository = $this->getDoctrine()->getRepository(newsletter::class);

        $newsletter = $repository->findAll();
        return $this->render('@App/newsletter.html.twig', array('newsletter'=>$newsletter));
    }

    public function telechargementAction()
    {

        $repository = $this->getDoctrine()->getRepository(telechargement::class);

        $telechargement = $repository->findAll();
        return $this->render('@App/telechargement.html.twig', array('telechargement'=>$telechargement));
    }

    public function cgvAction()
    {

        $repository = $this->getDoctrine()->getRepository(cgv::class);

        $cgv = $repository->findAll();
        return $this->render('@App/cgv.html.twig', array('cgv'=>$cgv));
    }

    public function marqueAction()
    {

        $repository = $this->getDoctrine()->getRepository(marque::class);

        $marque = $repository->findAll();
        return $this->render('@App/marque.html.twig', array('marque'=>$marque));
    }

    public function textmarqueAction()
    {

        $repository = $this->getDoctrine()->getRepository(textmarque::class);

        $textmarque = $repository->findAll();
        return $this->render('@App/textmarque.html.twig', array('textmarque'=>$textmarque));
    }

    public function contactAction()
    {

        $repository = $this->getDoctrine()->getRepository(contact::class);

        $contact = $repository->findAll();
        return $this->render('@App/contact.html.twig', array('contact'=>$contact));
    }

    public function certificatAction()
    {

        $repository = $this->getDoctrine()->getRepository(certificat::class);

        $certificat = $repository->findAll();
        return $this->render('@App/certificat.html.twig', array('certificat'=>$certificat));
    }

    public function tarifAction()
    {

        $repository = $this->getDoctrine()->getRepository(tarif::class);

        $tarif = $repository->findAll();
        return $this->render('@App/tarif.html.twig', array('tarif'=>$tarif));
    }

    public function savAction()
    {

        $repository = $this->getDoctrine()->getRepository(sav::class);

        $sav = $repository->findAll();
        return $this->render('@App/sav.html.twig', array('sav'=>$sav));
    }

    public function motpresidentAction()
    {

        $repository = $this->getDoctrine()->getRepository(motpresident::class);

        $motpresident = $repository->findAll();
        return $this->render('@App/motpresident.html.twig', array('motpresident'=>$motpresident));
    }


}