<?php
namespace Haven\Bundle\PersonaBundle\Form;

// Symfony includes
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactAddressType extends AbstractType {
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('id', 'text')
            ->add("type", 'hidden');
//            ->add("type", 'text');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        return array("data_class" => "Haven\Bundle\PersonaBundle\Entity\ContactAddress");
    }
    
    public function getName() {
        return "hasAddress";
    }
}

?>
