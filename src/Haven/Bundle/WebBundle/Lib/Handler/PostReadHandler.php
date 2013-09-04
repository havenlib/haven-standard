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

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;

class PostReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->findAll();
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function getAllPublished() {
        return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->findAllPublished();
    }

    public function getLastPublished($limit = null) {
        return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->findLastPublished($limit);
    }

    public function getAllOrderedByRank() {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            return $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->findAllOrderedByRank();
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function getByLocalizedSlug($slug, $language) {
        $entity = $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->findByLocalizedSlug($slug, $language);

        return $entity;
    }

    public function search($filters) {

        //Remove all empty filters
        $filters = array_filter($filters);

        return $entities = $this->em->getRepository("Haven\Bundle\WebBundle\Entity\Post")->search($filters);
    }

}

?>
