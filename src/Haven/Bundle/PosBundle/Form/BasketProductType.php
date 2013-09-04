<?php

namespace Haven\Bundle\PosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BasketProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('quantity')
                ->add('product', 'entity', array(
                    'class' => 'HavenPosBundle:Product',
                    'property' => 'name',
                    'required' => true,
//                    it is not possible to sort easily here cuz the info is multi langual and not the same for each type product,
//                    It should be sorted at display time, or maybe in event (data set ?)
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->where('p.status = true');
                    }
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\PosBundle\Entity\PurchaseProduct'
        ));
    }

    public function getName() {
        return 'haven_bundle_posbundle_purchaseproducttype';
    }

}
