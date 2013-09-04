<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Haven\Bundle\CmsBundle\Entity\Page as Entity;
use Haven\Bundle\CmsBundle\Form\PageType as Type;

class PageFormHandler {

    protected $read_handler;
    protected $language_read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(PageReadHandler $read_handler, LanguageReadHandler $language_read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->language_read_handler = $language_read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);
        $edit_form = $this->form_factory->create(new Type(), $entity);

        return $edit_form;
    }

    public function changeTemplate($data) {
        return $edit_form = $this->form_factory->create(new Type(), $data);
    }

    public function createNewForm() {
        $edit_form = $this->form_factory->create(new Type());

        return $edit_form;
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
