<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

abstract class ReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository($this->getDefaultEntityClass())->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository($this->getDefaultEntityClass())->findAll();
    }

    protected function getDefaultEntityClass() {
        throw new \Exception("You must implement " . __FUNCTION__ . " function in " . get_called_class());
    }

}

?>
