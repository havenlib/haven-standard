<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add("id")
                ->add('name')
//                ->add('translations', 'translation', array(
//                    'type' => new HtmlContentTranslationType()
//                    , 'allow_add' => true
//                    , "label" => false
//                    , 'prototype' => true
//                    , 'prototype_name' => '__name_trans__'
//                    , 'by_reference' => false
//                    , 'options' => array(
//                        'label' => false
//                    )
//                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\Content'
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_contenttype';
    }

}
