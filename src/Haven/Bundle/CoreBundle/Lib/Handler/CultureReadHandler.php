<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class CultureReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("HavenCoreBundle:Language")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository("HavenCoreBundle:Language")->findAll();
    }

    public function getAllPublished() {
        return $this->em->getRepository("HavenCoreBundle:Language")->findAllPublished();
    }

    public function getAllPublishedOrderedByRank($order = 'ASC') {
        return $this->em->getRepository("HavenCoreBundle:Language")->findAllPublishedOrderedByRank($order);
    }
    

}

?>
