<?php

namespace Haven\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InternalLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
//            ->add('route')
//            ->add('route_params')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CoreBundle\Entity\InternalLink'
        ));
    }

    public function getName()
    {
        return 'haven_bundle_corebundle_internallinktype';
    }
}
