<?php

namespace AppBundle\Form;

/*use Doctrine\DBAL\Types\TextType;*/
use AppBundle\Entity\catalogue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class pagesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', TextType::class)
            ->add ('catalogue', EntityType::class, [
                'class' => 'AppBundle\Entity\catalogue',
                'choice_label' => 'titre',
                'required'    => false,])
            ->add('file',FileType::class, [
                'mapped' =>false,
                'label' => 'Document',
                'required'=> false
                ])
            /*, array(
                'label' => 'logo',
                'required'    => false )*/
            /*->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save')))*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\pages'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Appbundle_pages';
    }
}
