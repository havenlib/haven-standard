<?php

namespace Haven\Bundle\PersonaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of TelephoneType
 *
 * @author themaster
 */
class TelephoneType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('telephone', 'integer')
                ->add('type', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
        'data_class' => 'Haven\Bundle\PersonaBundle\Entity\Telephone'
        ));
    }

    public function getName() {
        return 'haven_bundle_personabundle_telephonetype';
    }

}