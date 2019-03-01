<?php
namespace AppBundle\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtensionNow extends AbstractExtension
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('somme', array($this,'calculSomme')),new \Twig_SimpleFilter('rani_first', array($this,'raniaFunction')),new \Twig_SimpleFilter('slider_filtre', array($this,'sliderFunction')));

    }




     /*public function getGlobals() {


    return array(
    "myVariable" => $this->em->getRepository('AppBundle:infocontact')->findAll(),
      );
    }*/
    public function raniaFunction()
    {
        $logoConfig =$this->em->getRepository('AppBundle:motpresident')->findAll();
        return $logoConfig;
    }


    public function calculSomme()
    {
        $logoConfig =$this->em->getRepository('AppBundle:infocontact')->findAll();
        return $logoConfig;
    }

    public function sliderFunction()
    {
        $logoConfig =$this->em->getRepository('AppBundle:slider')->findAll();
        return $logoConfig;
    }


}