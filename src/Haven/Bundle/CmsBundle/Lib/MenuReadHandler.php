<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Haven\Bundle\CoreBundle\Lib\NestedSet\Manager as NestedSetManager;

class MenuReadHandler {

    protected $em;
    protected $security_context;
    protected $nsm;

    public function __construct(EntityManager $em, SecurityContext $security_context, NestedSetManager $nsm) {
        $this->em = $em;
        $this->security_context = $security_context;
        $config = $nsm->getConfiguration();
        $config->setClass('Haven\Bundle\CmsBundle\Entity\Menu');
        $this->nsm = $nsm;
    }

    public function get($id) {

        $entity = $this->nsm->fetchBranch($id);

        return $entity;
    }

//    public function getBranch($id) {
//        $test = $this->nsm->fetchBranchAsArray($id);
//
//        return $test;
//    }

    public function getAllRootMenus() {
        $roots = $this->em->getRepository("HavenCmsBundle:Menu")->findRootMenus();
        $entities = array();
        foreach ($roots as $root) {
            $entities[] = $this->nsm->fetchTree($root->getId());
        }

        return $entities;
    }

    public function getRootMenuByName($name) {
        $root = $this->em->getRepository("HavenCmsBundle:Menu")->findRootMenuByName($name);
        if (empty($root)) {
            return $root;
        }
        $entity = $this->nsm->fetchTree($root->getId());

        return $entity;
    }

    public function getBySlugForLanguage($slug, $language) {
        $entity = $this->em->getRepository("HavenCmsBundle:Menu")->findByLocalizedSlug($slug, $language);

        return $entity;
    }

}

?>
