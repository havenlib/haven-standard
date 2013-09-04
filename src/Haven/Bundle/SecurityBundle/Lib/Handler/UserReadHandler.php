<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\SecurityBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Haven\Bundle\CoreBundle\Lib\Handler\ReadHandler;

class UserReadHandler extends ReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("Haven\Bundle\SecurityBundle\Entity\User")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            return $this->em->getRepository("Haven\Bundle\SecurityBundle\Entity\User")->findAll();
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function getResetByUuid($uuid) {
        return $reset = $this->em->getRepository("Haven\Bundle\SecurityBundle\Entity\UserReset")->findOneByUuid($uuid);
    }

}

?>
