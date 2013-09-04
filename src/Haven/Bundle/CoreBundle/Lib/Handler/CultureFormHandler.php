<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Haven\Bundle\CoreBundle\Lib\Handler\CultureReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Haven\Bundle\CoreBundle\Form\ChooseCultureType as Type;

class CultureFormHandler {

    protected $read_handler; // devrait être son listhandler je pense
    protected $language_read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(CultureReadHandler $read_handler, LanguageReadHandler $language_read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->language_read_handler = $language_read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    /**
     * Creates an edit_form with all the translations objects added for status languages
     * @return Form 
     */
    public function createEditForm($symbol) {
        $current_language = $this->language_read_handler->getBySymbol($symbol);

        //reduit languages en un array()
        $existing_cultures = array();
        foreach ($current_language->getCultures() as $culture) {
            $existing_cultures[] = $culture->getSymbol();
        }

        
        $edit_form = $this->form_factory->create(new Type(), array('symboles' => $existing_cultures), array('display_language' => $current_language->getSymbol()));
        return $edit_form;
    }

}

?>
