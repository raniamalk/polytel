<?php

namespace AppBundle\Form;

/*use Doctrine\DBAL\Types\TextType;*/
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class devisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('email', TextType::class, array(
                'required' => false ))
            ->add('telephone', TextType::class, array(
                'required' => false ))
            ->add('message', TextareaType::class, array(
                'required' => false ))
            /*->add('publish', CheckboxType::class, array('required' => false, 'label'=> 'validé'))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'Envoyer')))*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\devis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Appbundle_devis';
    }
}
