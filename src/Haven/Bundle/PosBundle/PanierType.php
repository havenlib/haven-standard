<?php

namespace Haven\Bundle\PosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class ptype extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', date)
            ->add('product', 'collection', array(
                    'type' => new \Haven\Bundle\PosBundle\Form\ProductForm(),
                    'allow_add' => true,
                    'prototype' => true,
                    // Post update
                    'by_reference' => true,
                    ))
        ;
    }


public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Symfony\Component\Console\Command\Command',
        );
    }

    public function getName()
    {
        return 'HavenPosBundle_PanierType';
    }
}