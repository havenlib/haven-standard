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

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Haven\Bundle\PersonaBundle\Lib\Manipulator\PersonaManipulator;

class PersonaPersistenceHandler {

    protected $em;
    protected $security_context;
    protected $read_handler;
    protected $manipulator;

    public function __construct(PersonaReadHandler $read_handler, EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
    }

    public function batchSave($entities) {
        foreach ($entities as $entity) {
            $this->em->persist($entity = $this->manipulator->transformTo($entity));
        }

        $this->em->flush();
    }

    public function save($entity) {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete($id) {
        $entity = $this->read_handler->get($id);
        $this->em->remove($entity);
        $this->em->flush();
    }

}

?>
