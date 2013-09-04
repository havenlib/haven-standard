<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class PageContentPersistenceHandler {

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
