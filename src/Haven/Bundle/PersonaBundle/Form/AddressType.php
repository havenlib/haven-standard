<?php
namespace Haven\Bundle\PersonaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType {
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('id', 'hidden')
            ->add("country", 'entity', array(
                'class' => 'HavenPersonaBundle:Country',
                ))
            ->add("code_postal", 'text')
            ->add("ville", 'text')
            ->add("address", 'text')
            ->add("address2", 'text', array('required' => false))
            ->add("state", 'entity', array(
                'class' => 'HavenPersonaBundle:State'
            ))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        return array("data_class" => "Haven\Bundle\PersonaBundle\Entity\Address");
    }
    
    public function getName() {
        return "haven_bundle_personabundle_addresstype";
    }
}

?>
