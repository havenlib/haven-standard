<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class PageContentReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("HavenCmsBundle:PageContent")->find($id);

        if (!$entity)
            throw new \Exception('entity.not.found');

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository("HavenCmsBundle:PageContent")->findAll();
    }

    public function getAllPublished() {
        return $this->em->getRepository("HavenCmsBundle:PageContent")->findAllPublished();
    }

}

?>
