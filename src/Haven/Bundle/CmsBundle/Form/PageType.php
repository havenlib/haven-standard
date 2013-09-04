<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
//
//        echo "Template: ". $options['data']->getTemplate()->getName();
//        echo "<br />";
//        echo "<pre>";
//        print_r($options['data']->getTemplate()->getAreasAsArray());
//        echo "</pre>";
//        echo "<br />";
//        echo "<br />";
//        ;
        $builder
                ->add('translations', 'translation', array(
                    'type' => new PageTranslationType()
                    , 'allow_add' => true
                    , "label" => false
                    , 'prototype' => true
                    , 'prototype_name' => '__name_trans__'
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                    )
//                    need to put the data class to have default from the entity
//                    , 'empty_data' => "\Haven\Bundle\CmsBundle\Entity\PageTranslation"
                ))
                ->add('template', null, array(
                    "property" => "name"
                ))
                ->add('tpl', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'change.template'
                ))
                ->add('html_contents', "collection", array(
                    'type' => new PageContentType('Haven\Bundle\CmsBundle\Form\HtmlContentType')
                    , 'allow_add' => true
                    , "label" => false
                    , 'allow_delete' => true
                    , 'prototype' => true
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                        , 'areas' => (isset($options['data']) && $options['data']->getTemplate()) ? $options['data']->getTemplate()->getAreasAsArray() : array()
                    )
                ))
                ->add('text_contents', "collection", array(
                    'type' => new PageContentType('Haven\Bundle\CmsBundle\Form\TextContentType')
                    , 'allow_add' => true
                    , "label" => false
                    , 'allow_delete' => true
                    , 'prototype' => true
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                        , 'areas' => (isset($options['data']) && $options['data']->getTemplate()) ? $options['data']->getTemplate()->getAreasAsArray() : array()
                    )
                ))
                ->add('news_widgets', "collection", array(
                    'type' => new PageContentType('Haven\Bundle\CmsBundle\Form\NewsWidgetType')
                    , 'allow_add' => true
                    , "label" => false
                    , 'allow_delete' => true
                    , 'prototype' => true
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                        , 'areas' => (isset($options['data']) && $options['data']->getTemplate()) ? $options['data']->getTemplate()->getAreasAsArray() : array()
                    )
                ))
                ->add('save', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'save.page'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\Page'
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_pagetype';
    }

}
