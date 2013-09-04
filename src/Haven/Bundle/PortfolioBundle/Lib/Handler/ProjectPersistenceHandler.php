<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PortfolioBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProjectPersistenceHandler {

    protected $em;
    protected $security_context;

    public function __construct(ProjectReadHandler $read_handler, EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
    }

    public function batchSave($entities) {
        if ($this->security_context->isGranted('ROLE_Admin')) {
            foreach ($entities as $entity) {
                $this->em->persist($entity);
            }
            $this->em->flush();

            return true;
        }

        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function save($entity) {
        if ($this->security_context->isGranted('ROLE_Admin')) {
            $this->em->persist($entity);
            $this->em->flush();

            return true;
        }

        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function delete($id) {
        if ($this->security_context->isGranted('ROLE_Admin')) {
            $entity = $this->read_handler->get($id);
            $this->em->remove($entity);
            $this->em->flush();

            return true;
        }

        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

}

?>
