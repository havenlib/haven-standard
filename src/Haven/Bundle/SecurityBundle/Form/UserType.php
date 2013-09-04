<?php


/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'repeated', array('type' => 'password'
                    , "first_name" => "password"
                    , "second_name" => "confirmation"
                    , "invalid_message" => "mot.de.passe.pas.identiques"
                    , "required" => false
                    , 'label' => 'Password'
                ))
                ->add('status', 'choice', array(
                    'choices' => array(
                        1 => 'actif'
                        , 2 => 'inactif'
                    )
                    , 'multiple' => false
                ))
                ->add('locked', 'checkbox', array("required" => false))
                ->add('save', 'submit', array(
                    'attr' => array('class' => 'btn save-btn'),
                    'label' => 'save.user'
                ))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\SecurityBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'haven_bundle_securitybundle_utilisateurtype';
    }

}
