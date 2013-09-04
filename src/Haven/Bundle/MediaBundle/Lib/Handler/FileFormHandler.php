<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Lib\Handler;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;

class FileFormHandler {

    protected $read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(FileReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    public function createEditForm($id) {
        $entity = $this->read_handler->get($id);

        switch (get_class($entity)) {
            case "Haven\Bundle\MediaBundle\Entity\ImageFile":
                $form_class = "Haven\Bundle\MediaBundle\Form\ImageFileType";
                break;
            default:
                $form_class = "Haven\Bundle\MediaBundle\Form\FileType";
                break;
        }

        return $form = $this->doCreate($form_class, $entity);
    }

    public function createNewForm() {
        return $form = $this->doCreate('Haven\Bundle\MediaBundle\Form\UploadType');
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
