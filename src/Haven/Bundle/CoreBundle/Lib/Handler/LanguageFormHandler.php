<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Haven\Bundle\CoreBundle\Form\ChooseLanguageType;

class LanguageFormHandler {

    protected $read_handler; // devrait être son listhandler je pense
    protected $form_factory;
    protected $security_context;

    public function __construct(LanguageReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    /**
     * Creates an edit_form with all the translations objects added for status languages
     * @return Form 
     */
    public function createEditForm() {
        //reduit languages en un array()
        $existing_languages = $this->read_handler->getAll();
        array_walk($existing_languages, function (&$language) {
                    $language = $language->getSymbol();
                });


        $edit_form = $this->form_factory->create(new ChooseLanguageType(), array('symboles' => $existing_languages));

        return $edit_form;
    }

}

?>
