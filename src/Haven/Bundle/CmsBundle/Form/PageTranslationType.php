<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Haven\Bundle\CoreBundle\Repository\LanguageRepository;
use Haven\Bundle\CmsBundle\Entity\PageTranslation;

class PageTranslationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('status', 'choice', array(
                    'choices' => array(0 => "Inactive", 1 => "Publish", 2 => "Draft")
                ))
                ->add('title')
                ->add('slug')
                ->add('trans_lang', null, array(
                    "property" => "name"
                    , "label" => false
                    , 'query_builder' => function(LanguageRepository $er) {
                        return $er->filterByStatus(\Haven\Bundle\CoreBundle\Entity\Language::STATUS_PUBLISHED)
                                ->orderByRank()
                                ->getQueryBuilder();
                    }
                    , "empty_value" => false
                    , "attr" => array(
                        "class" => "hidden"
                    )
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\PageTranslation'
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_pagetranslationtype';
    }

}
