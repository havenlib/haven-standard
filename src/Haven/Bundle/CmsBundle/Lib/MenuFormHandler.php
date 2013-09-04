<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Haven\Bundle\CmsBundle\Entity\Menu as Entity;
use Haven\Bundle\CmsBundle\Form\MenuType as Type;
use Haven\Bundle\CmsBundle\Form\MenuExternalLinkType as External;
use Haven\Bundle\CmsBundle\Form\MenuInternalLinkType as Internal;

class MenuFormHandler {

    protected $read_handler; // devrait être son listhandler je pense
    protected $language_read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(MenuReadHandler $read_handler, LanguageReadHandler $language_read_handler, SecurityContext $security_context, FormFactory $form_factory) {
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
        $edit_form = $this->form_factory->create(new Type(), $entity->getNode());

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
//                        ->add('delete' , 'submit')
                        ->getForm()
        ;
    }

    /**
     * Create a form to add a child of type
     * @param integer $id
     * @return form
     */
    public function createAddChildForm($type, $id = null) {
        $entity = null;
        if (!empty($id)) {
            $entity = $this->read_handler->get($id)->getNode();
        }
        switch ($type) {
            case "internal":
                $form = $this->form_factory->create(new Internal, $entity);
                return $form;
                break;
            case "external":
                $form = $this->form_factory->create(new External, $entity);
                return $form;
                break;
        }
        return $form;
    }

}

?>
