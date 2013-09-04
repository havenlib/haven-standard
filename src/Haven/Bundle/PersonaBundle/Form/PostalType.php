<?php

namespace Haven\Bundle\PersonaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('master')
            ->add('address')
            ->add('address2')
            ->add('postal_code')
            ->add('city')
//            ->add('persona')
//            ->add('country')
//            ->add('state')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\PersonaBundle\Entity\Postal'
        ));
    }

    public function getName()
    {
        return 'haven_bundle_personabundle_postaltype';
    }
}
