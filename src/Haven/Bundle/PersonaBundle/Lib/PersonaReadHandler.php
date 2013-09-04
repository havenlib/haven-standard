<?php

namespace Haven\Bundle\PersonaBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

abstract class PersonaReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository($this->getEntityClass())->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository($this->getEntityClass())->findAll();
    }

    protected function getEntityClass() {
        return "Haven\Bundle\PersonaBundle\Entity\Persona";
    }

}

?>
