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

class ConfirmType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('confirmation')
                ->add('plainPassword', 'repeated', array('type' => 'password'
                    , "invalid_message" => "mot.de.passe.pas.identiques"
                    , "options" => array("required" => true)))
                ->add('confirm', 'submit')
//                ->add("uuid", "text")
        ;
    }

    public function getName() {
        return 'haven_bundle_securitybundle_confirmtype';
    }

}
