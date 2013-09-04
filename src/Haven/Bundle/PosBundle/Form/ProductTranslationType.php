<?php
namespace Haven\Bundle\PosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ProductTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        

        $builder
            ->add('caracteristique', 'textarea', array('attr' => array('class' => 'ckeditor'),'required'=>false))
	    ->add('Introduction', 'textarea' ,array('required' => false))
            ->add('ingredients', 'textarea', array('attr' => array('class' => 'ckeditor'),'required'=>false))
	    ->add('Avertissement', 'textarea',array('required' => false, 'label'=>'Précaution')) //ici legacy Avertissement devient précaution
	    ->add('mise_en_garde', 'textarea',array('required' => false))
	    ->add('contre_indications', 'textarea',array('required' => false))
            ->add('file', 'file', array('required' => false))
             ;
    }
    
    public function getDefaultOptions(array $options)
    {
            return array(
                'data_class' => 'Haven\Bundle\PosBundle\Entity\ProductTranslation'
            );
    }
    
    public function getOption($name){
        $options = $this->getDefaultOptions(array());
        return $options[$name];
    }
    
    public function getName()
    {
        return 'produit';
    }    
}
