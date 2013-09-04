<?php

namespace Haven\Bundle\PersonaBundle\Lib;

use Haven\Bundle\PersonaBundle\Lib\PersonaReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;

abstract class PersonaFormHandler {

    protected $read_handler; // devrait être son listhandler je pense
    protected $form_factory;
    protected $security_context;

    public function __construct(PersonaReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    /**
     * Creates an edit_form with all the translations objects added for status languages
     * @return Form 
     */
    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);
        $type = $this->getTypeClass();
        $edit_form = $this->form_factory->create(new $type(), $entity);

        return $edit_form;
    }

    /**
     * 
     * @param \Website\Bundle\SiteBundle\Entity\Entreprise $entreprise
     * @return a form for dossier, as dossierType or DossierRequerantType
     */
    public function createNewForm() {
        $type = $this->getTypeClass();
        $new_form = $this->form_factory->create(new $type());

        return $new_form;
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

    protected function getTypeClass() {
        return "Haven\Bundle\PersonaBundle\Form\PersonaType";
    }

}

?>
