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
use Haven\Bundle\CoreBundle\Repository\LanguageRepository;

class PostTranslationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', "text", array(
                    'required' => false,
                    'attr' => array("inline-editing" => true)
                ))
                ->add('subtitle', "text", array('required' => false))
                ->add('slug', "text", array('required' => false))
//                ->add('name', "text", array('required' => false))
                ->add('excerpt', "text", array('required' => false))
                ->add('content', "textarea", array(
                    'required' => false
//                    , 'label' => false
                    , 'attr' => array('class' => 'hiden')
                ))
                ->add('status', 'choice', array(
                    'choices' => array(0 => "Inactive", 1 => "Publish", 2 => "Draft")
                ))
//                ->add('image', "collection", array(
//                    'type' => new MediaType(),
//                    'allow_add' => true,
//                    'property_path' => false,
//                    'prototype' => true,
//                    'by_reference' => true,
//                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
//                ->add('pdf', "collection", array(
//                    'type' => new MediaType(),
//                    'allow_add' => true,
//                    'property_path' => false,
//                    'prototype' => true,
//                    'by_reference' => true,
//                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
//                ->add('text', "collection", array(
//                    'type' => new MediaType(),
//                    'allow_add' => true,
//                    'property_path' => false,
//                    'prototype' => true,
//                    'by_reference' => true,
//                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
//                ->add('other', "collection", array(
//                    'type' => new MediaType(),
//                    'allow_add' => true,
//                    'property_path' => false,
//                    'prototype' => true,
//                    'by_reference' => true,
//                    "attr" => array("class" => "coordinate", "data-join-class" => "coordinate")))
                ->add('trans_lang', null, array(
                    "property" => "name"
                    , "label" => false
                    , 'query_builder' => function(LanguageRepository $er) {
                        return $er->filterByStatus(\Haven\Bundle\CoreBundle\Entity\Language::STATUS_PUBLISHED)
                                ->orderByRank()
                                ->getQueryBuilder();
                    }
                    , "attr" => array(
                        "class" => "hidden"
                    )
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\WebBundle\Entity\PostTranslation'
        ));
    }

    public function getName() {
        return 'haven_bundle_webbundle_posttranslationtype';
    }

}
