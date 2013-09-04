<?php

namespace Haven\Bundle\PersonaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstname')
                ->add('lastname')
                ->add('sex')
                ->add('postal', "collection", array(
                    'type' => new PostalType(),
                    'allow_add' => true,
                    'prototype' => true,
                    // Post update
                    'by_reference' => true,
                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
                ->add('map', "collection", array(
                    'type' => new MapType(),
                    'allow_add' => true,
                    'prototype' => true,
                    // Post update
                    'by_reference' => true,
                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
                ->add('web', "collection", array(
                    'type' => new WebType(),
                    'allow_add' => true,
                    'prototype' => true,
                    'by_reference' => true,
                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
                ->add('telephone', "collection", array(
                    'type' => new TelephoneType(),
                    'allow_add' => true,
                    'prototype' => true,
                    'by_reference' => true,
                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
                ->add('time', "collection", array(
                    'type' => new TimeType(),
                    'allow_add' => true,
                    'prototype' => true,
                    'by_reference' => true,
                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\PersonaBundle\Entity\Person'
        ));
    }

    public function getName() {
        return 'haven_bundle_personabundle_persontype';
    }

}
