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
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostPersistenceHandler {

    protected $em;
    protected $security_context;
    protected $read_handler;

    public function __construct(PostReadHandler $read_handler, EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
    }

    public function save($entity, $rank = false) {
//        if (!$this->security_context->isGranted('ROLE_Admin')) {
            $this->em->persist($entity);
            $this->em->flush();

            /**
             * Set the default rank to max rank + 1
             */
            if ($rank)
                $this->em->getConnection()->exec("UPDATE Post AS p, (SELECT IFNULL(MAX(rank), 0) AS rank FROM Post) p2 SET p.rank = p2.rank + 1 WHERE p.id = " . $entity->getId());

            return true;
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function batchSave($entities) {
//        if ($this->security_context->isGranted('ROLE_Admin')) {

            foreach ($entities as $entity) {
                $this->em->persist($entity);
            }
            $this->em->flush();

            return true;
//        }
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function rank($entity, $new_rank) {

//        if ($this->security_context->isGranted('ROLE_Admin')) {
            $entities = $this->em->getRepository('HavenWebBundle:Post')->findAllFromRank($new_rank, $old_rank = $entity->getRank(), $entity->getId());
            $rank = ($new_rank < $old_rank) ? $new_rank : $old_rank;

            foreach ($entities as $e) {
                $e->setRank(($old_rank - $new_rank > 0) ? ++$rank : $rank++);
                $this->em->persist($e);
            }

            $entity->setRank($new_rank);
            $this->em->persist($entity);
            $this->em->flush();

            return true;
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

//    public function firstSave($entity) {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
//            $this->em->persist($entity);
//            $this->em->flush();
//
//
//            return true;
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
//    }

    public function delete($id) {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            $entity = $this->read_handler->get($id);
            $this->em->remove($entity);
            $this->em->flush();
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

}

?>
