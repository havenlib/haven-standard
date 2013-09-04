<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('template', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'change.template'
                ))
                ->add('translations', 'translation', array(
                    'type' => new PostTranslationType()
                    , 'allow_add' => true
                    , "label" => false
                    , 'prototype' => true
                    , 'prototype_name' => '__name_trans__'
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                    )
                ))
//                ->add('categories'/* , null, array(
//                          'expanded' => true,
//                          "multiple" => true) */
//                )
                ->add('postbegin_at', "date", array(
                    'required' => false,
//                    'widget' => 'single_text',
//                    'input' => 'timestamp',
                    'format' => 'dd-MM-yyyy',
                ))
                ->add('postend_at', "date", array(
                    'required' => false,
//                    'widget' => 'single_text',
//                    'input' => 'timestamp',
                    'format' => 'dd-MM-yyyy',
                ))
                ->add('status', 'choice', array(
                    'choices' => array(0 => "Inactive", 1 => "Publish", 2 => "Draft")
                ))
                ->add('save', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'save.post'
                ))
//                ->add('file', "file", array('required' => false, "attr" => array("multiple" => true)))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\WebBundle\Entity\Post'
        ));
    }

    public function getName() {
        return 'haven_bundle_webBundle_posttype';
    }

}
