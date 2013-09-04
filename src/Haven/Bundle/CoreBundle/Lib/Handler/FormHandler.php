<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;

abstract class FormHandler {

    protected $read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(ReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    /**
     * Pour rajouter des droits d'accès, surcharger la méthode et utiliser SecurityContext.
     * 
     * @return Form 
     */
    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);
        return $form = $this->doCreate($this->getDefaultTypeClass(), $entity);
    }

    /**
     * Pour rajouter des droits d'accès, surcharger la méthode et utiliser SecurityContext.
     * 
     */
    public function createNewForm() {
        return $form = $this->doCreate($this->getDefaultTypeClass());
    }

    protected function doCreate($type, $entity = null) {
        $type = is_object($type) ? $type : new $type();
        return $this->form_factory->create($type, $entity);
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
                        ->add('delete' , 'submit')
                        ->getForm()
        ;
    }

    protected function getDefaultTypeClass() {
        throw new \Exception("You must implement " . __FUNCTION__ . " function in " . get_called_class());
    }

}

?>
