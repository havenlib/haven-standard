<?php

namespace Haven\Bundle\CmsBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Haven\Bundle\CoreBundle\Lib\NestedSet\Manager as NestedSetManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenuPersistenceHandler {

    protected $em;
    protected $security_context;
    protected $nsm;
    protected $read_handler;

    public function __construct(MenuReadHandler $read_handler, EntityManager $em, SecurityContext $security_context, NestedSetManager $nsm) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
        $config = $nsm->getConfiguration();
        $config->setClass('Haven\Bundle\CmsBundle\Entity\Menu');
        $this->nsm = $nsm;
    }

    public function createRootMenu($entity) {
        $entity->setType("root");
        $rootNode = $this->nsm->createRoot($entity);

        return $rootNode;
    }

    public function createChildMenuForUrl($entity, $parent) {

        $rootNode = $this->nsm->fetchBranch($parent);
        $rootNode->addChild($entity);

        return $rootNode;
    }

    public function createChildMenuForPage($entity, $parent, $page = null) {
        $rootNode = $this->nsm->fetchBranch($parent);
//        $curNode = $rootNode;
//        while(!$curNode->isRoot()){
//        echo '<p>-->'.$curNode->getNode()->getLink()->getSlug().'<--</p>';
//            $curNode = $curNode->getParent();
//        }
//        echo '<p>-->'.$curNode->getId().'<--</p>';
//foreach($rootNode->getParent() as $node){
//    echo $node->getNode()->getSlug();
//}
//        echo $rootNode->getNode()->getSlug();


        foreach ($entity->getTranslations() as $translation) {
            $translation->setSlug(($rootNode->getNode()->getSlug() != "") ? $rootNode->getNode()->getSlug() . "/" . $translation->getSlug() : $translation->getSlug());
            $link = new \Haven\Bundle\CoreBundle\Entity\InternalLink();
            $link->setRoute("HavenWebBundle_PageDisplaySlug");
            $link->setRouteParams(serialize(array(
                "slug" => $page->getSlug($translation->getTransLang()->getSymbol())
                , "_locale" => $translation->getTransLang()->getSymbol()
            )));
            $translation->setLink($link);
        }
        $rootNode->addChild($entity);

        return $rootNode;
    }

    public function save($entity, $page = null) {
        $node = $this->nsm->wrapNode($entity);

        if ($node->getNode()->getType() == "internal") {
            foreach ($node->getNode()->getTranslations() as $translation) {
                //                $translation->setSlug(($rootNode->getNode()->getSlug()!="")?$rootNode->getNode()->getSlug()."/".$translation->getSlug():$translation->getSlug());
                $link = $translation->getLink();
                if (empty($link)) {
                    $link = new \Haven\Bundle\CoreBundle\Entity\InternalLink();
                }
                $link->setRoute("HavenWebBundle_PageDisplaySlug");
                $link->setRouteParams(serialize(array(
                    "slug" => $page->getSlug($translation->getTransLang()->getSymbol())
                    , "_locale" => $translation->getTransLang()->getSymbol()
                )));
                $translation->setLink($link);
            }
            $this->updateSlug($node);
        }
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete($id) {
//      for some reason the links dont delete on cascade, it seems to work with normal function, not with nested set, if we do it otherwise it tries to recreate the parent.
        $entity = $this->read_handler->get($id);

        if (!$entity) {
            throw new NotFoundHttpException('entity.not.found');
        }

        $entity2 = clone $entity;

        $links = array();
        foreach ($entity->getTranslations() as $translation) {
            $links[] = $translation->getLink();
        }
        $node = $this->nsm->wrapNode($entity2);
        $node->delete();

//            $this->em->flush();
        foreach ($links as $link) {
            $this->em->remove($link);
        }
        $this->em->flush();
//            $this->em->flush()
    }

    private function updateSlug($node) {
        if ($node->getNode()->getType() == "internal") {
            foreach ($node->getNode()->getTranslations() as $translation) {
                $translation->setSlug(($node->getParent()->getNode()->getFullSlug() != "") ? $node->getParent()->getNode()->getFullSlug($translation->getTransLang()) . "/" . $translation->getSlug() : $translation->getSlug());
            }
            if ($node->hasChildren()) {
                foreach ($node->getChildren() as $child) {
                    $this->updateSlug($child);
                }
            }
        }
    }

}

?>
