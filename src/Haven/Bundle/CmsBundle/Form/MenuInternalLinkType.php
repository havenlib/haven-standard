<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Haven\Bundle\CmsBundle\Repository\PageRepository;

class MenuInternalLinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('translations', 'translation', array(
                    'type' => new MenuInternalLinkTranslationType()
                    , 'allow_add' => true
                    , "label" => false
                    , 'prototype' => true
                    , 'prototype_name' => '__name_trans__'
                    , 'by_reference' => false
                    , 'options' => array(
                        'label' => false
                    )
                ))
                ->add("page", "entity", array(
                    "property" => "title"
                    ,"class" => "Haven\Bundle\CmsBundle\Entity\Page"
                    , "label" => false
                    , "mapped" => false
                    , 'query_builder' => function(PageRepository $er) {
                        return $er->getQueryBuilder();
                    }
                ))
                ->add('save', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'save.menu'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\Menu'
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_menuinternallinktype';
    }

}
