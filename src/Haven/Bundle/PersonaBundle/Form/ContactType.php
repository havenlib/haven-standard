<?php

namespace Haven\Bundle\PersonaBundle\Form;

// Symfony includes
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('id', 'hidden')
                ->add("firstname", 'text')
                ->add("lastname", 'text')
                ->add("contact_address", "collection", array('type' => new \Haven\Bundle\PersonaBundle\Form\ContactAddressType()))
                ->add('telephone', "text", array('required' => false))
                ->add('title', 'choice', array('choices' => array('1' => 'Mme', '2' => 'M'), 'multiple' => false, 'expanded' => true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array("data_class" => "Haven\Bundle\PersonaBundle\Entity\Contact");
    }

    public function getName() {
        return "haven_bundle_personabundle_contacttype";
    }

}

?>
