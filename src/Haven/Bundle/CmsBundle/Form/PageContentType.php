<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageContentType extends AbstractType {

    protected $i = 0;
    protected $content_type = null;

    public function __construct($content_type) {
        $this->content_type = $content_type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('area', 'choice', array(
                    'choices' => $options['areas']
                    , 'multiple' => false
                    , 'required' => false
                ))
                ->add('content', new $this->content_type(), array(
                    "label" => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\PageContent'
            , 'areas' => array()
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_pagecontenttype';
    }

}
