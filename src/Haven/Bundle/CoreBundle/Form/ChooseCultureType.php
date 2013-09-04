<?php

namespace Haven\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Haven\Bundle\CoreBundle\Lib\Locale;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChooseCultureType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('symboles', 'choice', array(
            'choices' => Locale::getAvailableDisplayCulture($options['display_language']),
            'multiple' => true,
            'expanded' => true,
        ))->add('language', 'hidden');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'display_language' => null
        ));
    }
    public function getName() {
        return 'haven_bundle_corebundle_chooseculturetype';
    }
}

?>
