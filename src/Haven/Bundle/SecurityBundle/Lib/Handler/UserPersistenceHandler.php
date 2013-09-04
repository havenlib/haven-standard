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
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Haven\Bundle\SecurityBundle\Entity\UserReset;

class UserPersistenceHandler {

    protected $em;
    protected $security_context;
    protected $encoder_factory;
    protected $read_handler;

    public function __construct(UserReadHandler $read_handler, EntityManager $em, SecurityContext $security_context, EncoderFactory $encoder_factory) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->encoder_factory = $encoder_factory;
        $this->read_handler = $read_handler;
    }

    public function save($entity) {

//        if ($this->security_context->isGranted('ROLE_Admin')) {
            if (0 !== strlen($password = $entity->getPlainPassword())) {
                $encoder = $this->encoder_factory->getEncoder($entity);
                $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            }

            $this->em->persist($entity);
            $this->em->flush();

            return true;
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

    public function delete($id) {
//        if ($this->security_context->isGranted('ROLE_Admin')) {
            $entity = $this->read_handler->get($id);
            $this->em->remove($entity);
            $this->em->flush();

            return true;
//        }
//
//        throw new AccessDeniedException("you.dont.have.right.for.this.action");
    }

//    public function saveWithReset($entity) {
//        if (0 !== strlen($password = $entity->getPlainPassword())) {
//            $encoder = $this->encoder_factory->getEncoder($entity);
//            $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
//        }
//
//        $this->em->persist($entity);
//        $this->em->flush();
//
//        return $reset = $this->createReset($entity);
//    }

    public function createReset($entity) {
        $this->removeResets($entity);

        $reset = new UserReset();
        $reset->setUser($entity);

        $this->em->persist($reset);
        $this->em->flush();

        return $reset;
    }

    public function removeResets($entity) {
        $resets = $this->em->createQuery("SELECT ur FROM HavenSecurityBundle:UserReset ur WHERE ur.user = :id")
                ->setParameter("id", $entity->getId())
                ->getResult();

        foreach ($resets as $reset) {
            $this->em->remove($reset);
        }

        $this->em->flush();
    }

}

?>
