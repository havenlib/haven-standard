<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;
use Doctrine\Common\Annotations\AnnotationReader;
use \ReflectionClass;

/**
 * Haven\Bundle\CmsBundle\Entity\Content
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\CmsBundle\Repository\ContentRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * "html"="Haven\Bundle\CmsBundle\Entity\HtmlContent", 
 * "text"="Haven\Bundle\CmsBundle\Entity\TextContent", 
 * "widget"="Haven\Bundle\CmsBundle\Entity\Widget", 
 * "news_widget"="Haven\Bundle\CmsBundle\Entity\NewsWidget", 
 * })
 */
class Content extends Translatable {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="PageContent", mappedBy="content", cascade={"persist"})
     */
    private $page_contents;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     */
    public function setActif($actif) {
        $this->actif = $actif;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif() {
        return $this->actif;
    }

    public function __toString() {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Content
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->page_contents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add page_contents
     *
     * @param \Haven\Bundle\CmsBundle\Entity\PageContent $pageContents
     * @return Content
     */
    public function addPageContent(\Haven\Bundle\CmsBundle\Entity\PageContent $pageContents) {
        $this->page_contents[] = $pageContents;

        return $this;
    }

    /**
     * Remove page_contents
     *
     * @param \Haven\Bundle\CmsBundle\Entity\PageContent $pageContents
     */
    public function removePageContent(\Haven\Bundle\CmsBundle\Entity\PageContent $pageContents) {
        $this->page_contents->removeElement($pageContents);
    }

    /**
     * Get page_contents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPageContents() {
        
        return $this->page_contents;
    }

//    public static function getDiscriminatorMap() {
//        $reader = new AnnotationReader();
//        
//        return $reader->getClassAnnotation(new ReflectionClass(__CLASS__), "\Doctrine\ORM\Mapping\DiscriminatorMap");
//    }
//
//    public function getDiscriminator() {
//        $discriminator_map = self::getDiscriminatorMap();
//        
//        return array_search(get_class($this), $discriminator_map->value);
//    }

//    public function is($class) {
//        
//        return ($this instanceof $class);
//    }

    /**
     * 
     * @return string
     */
    public function getMethod() {
//        default method set to include, must overide to change, methods are use to define how to display.
//        @todo, make a renderer object to take care of this ?
        return "include";
    }

    /**
     * 
     * @return string
     */
    public function getTemplate(){
    
//        @TODO: the template could be saved in database for each content but even better would be to have it save per areatypes (so in a theatre the template could be something but in the sidebar something else ?)
//        could probably be done only by having 2 different content created, and use 2 different templates. Thought the important here would be to have a template object that can either load or take from the database, in php or html or twig
        return false;
    }

}