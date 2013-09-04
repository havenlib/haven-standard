<?php

namespace Haven\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageContentInlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('area')
            ->add('page', null, array(
                "property" => 'id'
            ))
            ->add('content', new HtmlContentType(), array(
                'label' =>false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\CmsBundle\Entity\PageContent'
        ));
    }

    public function getName()
    {
        return 'haven_bundle_cmsbundle_pagecontenttype';
    }
}
