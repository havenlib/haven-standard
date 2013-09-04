<?php

namespace Haven\Bundle\PosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BasketType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('memo')
                ->add('purchase_products', "collection", array(
                    "type" => new BasketProductType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    // Post update
                    'by_reference' => true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\PosBundle\Entity\Purchase',
        ));
    }

    public function getName() {
        return 'haven_bundle_posbundle_baskettype';
    }

}
