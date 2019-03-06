<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 07/11/2018
 * Time: 11:20
 */
namespace AppBundle\Controller;


use AppBundle\Entity\marque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\marqueType;
use Sylius\Component\Product\Model\Product;
use Sylius\Component\Product\Model\ProductTranslation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository;


use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Translation\TranslatableEntityLocaleAssignerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;




class marqueController extends Controller
{

    public function addAction(Request $request){

        $marque = new marque();

        $form = $this->createForm(marqueType::class, $marque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* echo "<pre>";
            var_dump($file);die('ici');*/
            $file = $request->files->get('marque')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $marque->setPath($filename);

            $em = $this->getDoctrine()->getManager();
            $marque->upload();
            $em->persist($marque);
            $em->flush();

            return $this->redirect($this->generateUrl('marque_list'));
        }

        $formView=$form->createView();

        return $this->render('@App/marqueadd.html.twig', array('form'=>$formView));

    }



    public function listAction (){


            $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
            $marque = $repository->findAll();

            return $this->render('@App/marquelist.html.twig', array('marque'=>$marque));


    }

    public function deleteAction($id)
    {


        $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
        $marque = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($marque);
        $em->flush();


        return $this->redirect($this->generateUrl('marque_list'));


    }

    public function editAction(Request $request, $id) {
        $marque = new marque();
        $marque = $this->getDoctrine()->getRepository(marque::class)->find($id);
        $form = $this->createForm(marqueType::class, $marque);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get('marque')['file'];
            $uploads_directory = $this->getParameter('uploads_directory');

            if ($file != null){
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploads_directory, $filename );
            $marque->setPath($filename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $marque->upload();
            $entityManager->flush();
            return $this->redirectToRoute('marque_list');
        }

        return $this->render('@App/marqueedit.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function marqueAction (){

        $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
        $product = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
        $marque = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('AppBundle:textmarque');
        $textmarque = $repository->findAll();

        return $this->render('@App/nosmarques.html.twig', array('marque'=>$marque, 'textmarque'=>$textmarque, 'product'=>$product));


    }

    public function ProductsByMarqueAction (Request $request){

       /* $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
        $product = $repository->findAll();*/

       /* $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
        $marque = $repository->findAll();*/







     /*  $marque= array('marque_name'=>$marque_name);
                $this->get('session')->set('marque', $marque);

                return new Response(json_encode($marque), 200);


        $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
        $product = $repository->findBy([
            'marque' => $marque_name,
        ]);*/
        $marque_count = $request->request->get('marque_count');

        for ($i=0; $i<=$marque_count; $i++){
        $marque_name= $request->request->get('marque_name_sjksjksjkjksh'.$i);


       /* var_dump($marque_name,$marque_count);die('stop it');*/

        }


     /*   for ($j = 0; $j <= $marque_count; $j++) {

            if ($j==0){
                $marque_name=  $request->request->get('marque_name_sjksjksjkjksh');

            }
            else{
                $marque_name=  $request->request->get('marque_name_sjksjksjkjksh'.$j);
                var_dump($marque_name);die('stop it');

            }

        }*/



        $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
        $product = $repository->findBy([
            'marque' => $marque_name,
        ]);





        /*var_dump($marque_name);
        die('yes');*/


        /*$em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('Sylius\Component\Product\Model\Product')->createQueryBuilder('p')->select('code')
            ->where('p.marque like  :marque_name')
            ->setParameter('marque_name', $marque_name)
            ->getQuery()->getResult();*/

       /* $repository = $this->getDoctrine()
            ->getRepository(Product::class);

        $query = $repository->createQueryBuilder('p')
            ->where('p.marque like  :marque_name')
            ->setParameter('marque_name', $marque_name)
            ->getQuery();

        $product = $query->getResult();*/



        return $this->render('@App/productsmarques.html.twig', array('product'=>$product));


    }



    public function ProductsByMarquenomAction (Request $request,$nom){

        /* $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
         $product = $repository->findAll();*/

        /* $repository = $this->getDoctrine()->getRepository('AppBundle:marque');
         $marque = $repository->findAll();*/







        /*  $marque= array('marque_name'=>$marque_name);
                   $this->get('session')->set('marque', $marque);

                   return new Response(json_encode($marque), 200);


           $repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
           $product = $repository->findBy([
               'marque' => $marque_name,
           ]);*/


       /* $marque_count = $request->request->get('marque_count');

        for ($i=0; $i<=$marque_count; $i++){
            $marque_name= $request->request->get('marque_name_sjksjksjkjksh'.$i);


             var_dump($marque_name,$marque_count);die('stop it');

        }*/


        /*   for ($j = 0; $j <= $marque_count; $j++) {

               if ($j==0){
                   $marque_name=  $request->request->get('marque_name_sjksjksjkjksh');

               }
               else{
                   $marque_name=  $request->request->get('marque_name_sjksjksjkjksh'.$j);
                   var_dump($marque_name);die('stop it');

               }

           }*/


        /*var_dump($marque_name);
        die('yes');*/




        /* $repository = $this->getDoctrine()
             ->getRepository(Product::class);

         $query = $repository->createQueryBuilder('p')
             ->where('p.marque like  :marque_name')
             ->setParameter('marque_name', $marque_name)
             ->getQuery();

         $product = $query->getResult();*/

        /*$repository = $this->getDoctrine()->getRepository('Sylius\Component\Product\Model\Product');
        $product = $repository->findBy([
            'marque' => $nom,
        ]);*/



        $em = $this->getDoctrine()->getManager();



        $product = $em->getRepository('Sylius\Component\Product\Model\Product')->createQueryBuilder('p')
            ->where('p.marque like  :marque_name')
            ->setParameter('marque_name', $nom)
            /*->leftJoin('p.id', 'sylius_product_translation')*/
            ->leftJoin(ProductTranslation::class, 't', 'WITH', 't.id = p.id')
            ->getQuery()->getResult();



        /*$product = $em->getRepository('Sylius\Component\Product\Model\ProductTranslation')->createQueryBuilder('t')
            ->Join(Product::class, 'p')
            ->where('p.marque like  :marque_name')
            ->setParameter('marque_name', $nom)
            ->andwhere('p.id = t.translatable_id')
            ->getQuery()->getResult();*/




        return $this->render('@App/productsmarques.html.twig', array('product'=>$product));


    }

}