<?php

/*
 * This persona is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * persona that was distributed with this source code.
 */

namespace Haven\Bundle\PersonaBundle\Lib\Handler;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;

class PersonaFormHandler {

    protected $read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(PersonaReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);

        switch (get_class($entity)) {
            case "Haven\Bundle\PersonaBundle\Entity\Persona":
                $form_class = "Haven\Bundle\PersonaBundle\Form\ImagePersonaType";
                break;
            default:
                $form_class = "Haven\Bundle\PersonaBundle\Form\PersonaType";
                break;
        }

        return $form = $this->doCreate($form_class, $entity);
    }

    public function createNewForm() {
        return $form = $this->doCreate('Haven\Bundle\PersonaBundle\Form\PersonaType');
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
                        ->add('delete', 'submit')
                        ->getForm()
        ;
    }

}

?>
