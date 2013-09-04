<?php

namespace Haven\Bundle\PersonaBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class PersonaPersistenceHandler {

    protected $em;
    protected $security_context;

    public function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function save($entity) {
        $this->em->persist($entity);
        $this->em->flush();
    }

}

?>
