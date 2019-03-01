<?php

namespace AppBundle\Form;

/*use Doctrine\DBAL\Types\TextType;*/
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class infocontactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('adresse', TextType::class, array(
                'required' => false ))
            ->add('email', TextType::class, array(
                'required' => false ))
            ->add('telephone', TextType::class, array(
                'required' => false ))
            ->add('fax', TextType::class, array(
                'required' => false ))
            ->add('facebook', TextType::class, array(
                'required' => false ))
            ->add('linkedin', TextType::class, array(
                'required' => false ))
            ->add('twitter', TextType::class, array(
                'required' => false ))
            ->add('instagram', TextType::class, array(
                'required' => false ))
            ->add('youtube', TextType::class, array(
                'required' => false ))
            ->add('metadescription', TextareaType::class, array(
                'required' => false ))
            ->add('metakeywords', TextareaType::class, array(
                'required' => false ))
            ->add('file',FileType::class, [
                'mapped' =>false,
                'label' => 'logo',
                'required'=> false
                ]
            /*, array(
                'label' => 'logo',
                'required'    => false )*/)
            /*->add('save', SubmitType::class, array(
                'attr' => array('class' => 'Valider')))*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\infocontact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Appbundle_infocontact';
    }
}
