<?php

namespace Haven\Bundle\PosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('date')
//            ->add('last_update')
            ->add('status')
            ->add('memo')
//            ->add('delivery_name')
//            ->add('delivery_address1')
//            ->add('delivery_address2')
//            ->add('delivery_telephone')
//            ->add('delivery_city')
//            ->add('delivery_postal_code')
//            ->add('delivery_state')
//            ->add('delivery_country')
//            ->add('invoicing_name')
//            ->add('invoicing_address1')
//            ->add('invoicing_address2')
//            ->add('invoicing_telephone')
//            ->add('invoicing_city')
//            ->add('invoicing_postal_code')
//            ->add('invoicing_state')
//            ->add('invoicing_country')
            ->add('purchase_total_raw')
            ->add('purchase_total_tax')
            ->add('purchase_total_charges')
            ->add('delivery_charge')
            ->add('purchase_currency')
            ->add('confirmation')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Haven\Bundle\PosBundle\Entity\Purchase'
        ));
    }

    public function getName()
    {
        return 'haven_bundle_posbundle_purchasetype';
    }
}
