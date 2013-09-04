<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class PageReadHandler {

    protected $em;
    protected $security_context;

    function __construct(EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function get($id) {

        $entity = $this->em->getRepository("HavenCmsBundle:Page")->find($id);

        return $entity;
    }

    public function getAll() {
        return $this->em->getRepository("HavenCmsBundle:Page")->findAll();
    }

    public function getList($lang = null) {
        return $this->em->getRepository("HavenCmsBundle:Page")->getListForLang();
    }

    public function getAllPublished() {
        return $this->em->getRepository("HavenCmsBundle:Page")->findAllPublished();
    }

    public function getBySlugForLanguage($slug, $language){
        $entity = $this->em->getRepository("HavenCmsBundle:Page")->findByLocalizedSlug( $slug, $language);

        return $entity;        
    }
}

?>
