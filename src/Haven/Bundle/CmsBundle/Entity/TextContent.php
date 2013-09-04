<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextContent
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TextContent extends Content {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $status;

    /**
     * @var \Haven\Bundle\CmsBundle\Entity\Page
     */
    protected $page;

    /**
     * @ORM\OneToMany(targetEntity="TextContentTranslation", mappedBy="parent", cascade={"persist"})
     */
    protected $translations;

    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TextContent
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    public function getContent($lang = null) {
        return $this->getTranslated('Content', $lang);
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return TextContent
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
     * Add translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\TextContentTranslation $translations
     * @return TextContent
     */
    public function addTranslation(\Haven\Bundle\CmsBundle\Entity\TextContentTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\TextContentTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\CmsBundle\Entity\TextContentTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations() {
        return $this->translations;
    }

    /**
     * Set page
     *
     * @param \Haven\Bundle\CmsBundle\Entity\Page $page
     * @return TextContent
     */
    public function setPage(\Haven\Bundle\CmsBundle\Entity\Page $page = null) {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Haven\Bundle\CmsBundle\Entity\Page 
     */
    public function getPage() {
        
        return $this->page;
    }
    
    public function __toString() {
        
        return "-->".$this->getId();
    }
    
    public function getTemplate(){
        
        return 'HavenCmsBundle:Template:text_content.html.twig';
    }
}