<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('path')
                ->add('areas', 'collection', array(
                    'type' => new AreaType()
                    ,'allow_add' => true
                    ,'prototype' => true
                    ,'by_reference' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\Template'
        ));
    }

    public function getName() {
        return 'haven_bundle_cmsbundle_templatetype';
    }

}
