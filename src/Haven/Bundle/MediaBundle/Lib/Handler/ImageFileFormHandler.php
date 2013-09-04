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
use Haven\Bundle\CoreBundle\Lib\Handler\FormHandler;
use Symfony\Component\Form\FormFactory;

class ImageFileFormHandler {

    protected $read_handler;
    protected $form_factory;
    protected $security_context;

    public function __construct(FileReadHandler $read_handler, SecurityContext $security_context, FormFactory $form_factory) {
        $this->read_handler = $read_handler;
        $this->form_factory = $form_factory;
        $this->security_context = $security_context;
    }

    public function createResizeForm($id) {
        $entity = $this->read_handler->get($id);

        return $form = $this->doCreate('Haven\Bundle\MediaBundle\Form\ResizeType', array('width' => $entity->getWidth(), 'height' => $entity->getHeight()));
    }

    public function createCropForm($id) {
        $entity = $this->read_handler->get($id);

        return $form = $this->doCreate('Haven\Bundle\MediaBundle\Form\CropType', array('width' => $entity->getWidth(), 'height' => $entity->getHeight()));
    }

    public function createNewForm() {
        return $form = $this->doCreate('Haven\Bundle\MediaBundle\Form\UploadType');
    }

    protected function doCreate($type, $data = null) {
        $type = is_object($type) ? $type : new $type();
        return $this->form_factory->create($type, $data);
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
