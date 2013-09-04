<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Haven\Bundle\CmsBundle\Entity\Template as Entity;
use Haven\Bundle\CmsBundle\Form\TemplateType as Type;

class TemplateFormHandler {

    protected $read_handler; // devrait être son listhandler je pense
    protected $language_read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(TemplateReadHandler $read_handler, LanguageReadHandler $language_read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->language_read_handler = $language_read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    /**
     * Creates an edit_form with all the translations objects added for status languages
     * @return Form 
     */
    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);
        $edit_form = $this->form_factory->create(new Type(), $entity);

        return $edit_form;
    }

    /**
     * 
     * @param \Website\Bundle\SiteBundle\Entity\Entreprise $entreprise
     * @return a form for dossier, as dossierType or DossierRequerantType
     */
    public function createNewForm() {
        $entity = new Entity();
        $create_form = $this->form_factory->create(new Type(), $entity);

        return $create_form;
    }

    /**
     * Create the simple delete form
     * @param integer $id
     * should create an abstract form handler that whould have that one already
     * @return form
     */
    public function createDeleteForm($id) {
        return $this->form_factory->createBuilder('form', array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}

?>
