<?php

namespace Haven\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Haven\Bundle\CoreBundle\Lib\Locale;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChooseLanguageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('symboles', "choice", array(
                    "choices" => Locale::getAvailableDisplayLanguage(Locale::getDefault())
                    , 'multiple' => true
                    , 'expanded' => true
                ))
        ;
    }



    public function getName() {
        return 'haven_bundle_corebundle_chooselanguagetype';
    }
    
}
