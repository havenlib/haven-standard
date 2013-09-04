<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PosBundle\Lib\Handler;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;

class ProductReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("Haven\Bundle\PosBundle\Entity\Product")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository("Haven\Bundle\PosBundle\Entity\Product")->findAll();
    }

    public function getAllPublished() {
        if ($this->security_context->isGranted('ROLE_Admin')) {
            return $this->em->getRepository("Haven\Bundle\PosBundle\Entity\Product")->findAllPublished();
        }

        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function getLastPublished($limit = null) {
        return $this->em->getRepository("Haven\Bundle\PosBundle\Entity\Product")->findLastPublished($limit);
    }

}

?>
