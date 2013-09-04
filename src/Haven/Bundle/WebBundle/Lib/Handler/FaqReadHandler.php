<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;

class FaqReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Faq")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Faq")->findAll();
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function getAllPublished() {
        return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Faq")->findAllPublished();
    }

    public function getAllOrderedByRank() {
        return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Faq")->findAllOrderedByRank();
    }

}

?>