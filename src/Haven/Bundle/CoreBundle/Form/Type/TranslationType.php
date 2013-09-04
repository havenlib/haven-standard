<?php

namespace Haven\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\EventListener\ResizeFormListener;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This type ressemble the collection type but add a form for each language available in the prototype (the prototype becomes an array of form view)
 */
class TranslationType extends AbstractType {

    protected $read_handler;

    public function __construct(LanguageReadHandler $read_handler) {
        $this->read_handler = $read_handler;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $languages = $this->read_handler->getAllByRank()->getResult();
        if ($options['allow_add'] && $options['prototype']) {
            $count = 0;
            foreach ($languages as $language) {
                $prototype = $builder->create($count++, $options['type'], array_replace(array(
                    'label' => $options['prototype_name'] . 'label__',
                                ), $options['options']));
//              Default for empty_data is a closure, if not default use the object to 
                if (is_string($options["empty_data"])) {
                    $entity = new $options["empty_data"]();
                    $entity->setTransLang($language);
                    $prototype->setData($entity);
                }
                $prototype->get("trans_lang")->setData($language);
//            print_r(array_keys($temp->get("trans_lang")->getAttributes()));
                $prototype_array[] = $prototype->getForm();
            }

            $builder->setAttribute('prototype', $prototype_array);
        }

        $resizeListener = new ResizeFormListener(
                $options['type'], $options['options'], $options['allow_add'], $options['allow_delete']
        );

        $builder->addEventSubscriber($resizeListener);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars = array_replace($view->vars, array(
            'allow_add' => $options['allow_add'],
            'allow_delete' => $options['allow_delete'],
        ));

        if ($form->getConfig()->hasAttribute('prototype')) {
            foreach ($form->getConfig()->getAttribute('prototype') as $temp) {
                $view->vars['prototype'][] = $temp->createView($view);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options) {
        if ($form->getConfig()->hasAttribute('prototype') && $view->vars['prototype'][0]->vars['multipart']) {
            $view->vars['multipart'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $optionsNormalizer = function (Options $options, $value) {
                    $value['block_name'] = 'entry';

                    return $value;
                };

        $resolver->setDefaults(array(
            'allow_add' => false,
            'allow_delete' => false,
            'prototype' => true,
            'prototype_name' => '__name__',
            'type' => 'text',
            'options' => array(),
        ));

        $resolver->setNormalizers(array(
            'options' => $optionsNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'translation';
    }

}