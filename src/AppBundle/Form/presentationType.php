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

class presentationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class, array(
                'required' => false ))
            ->add('metadescription', TextareaType::class, array(
                'required' => false ))
            ->add('metakeywords', TextareaType::class, array(
                'required' => false ))
            ->add('file',FileType::class, [
                'mapped' =>false,
                'label' => 'Image',
                'required'=> false
                ])
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
            'data_class' => 'AppBundle\Entity\presentation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Appbundle_presentation';
    }
}