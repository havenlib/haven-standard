<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsWidget
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NewsWidget extends Widget {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="maximum", type="integer", nullable=true)
     */
    protected $maximum;

    /**
     * @ORM\OneToMany(targetEntity="NewsWidgetTranslation", mappedBy="parent", cascade={"persist"})
     */
    protected $translations;

    public function getName($lang = null) {
        return $this->getTranslated('Name', $lang);
    }

    public function getContent($lang = null) {
        return $this->getTranslated('Content', $lang);
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
     * Constructor
     */
    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\NewsWidgetTranslation $translations
     * @return NewsWidget
     */
    public function addTranslation(\Haven\Bundle\CmsBundle\Entity\NewsWidgetTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\NewsWidgetTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\CmsBundle\Entity\NewsWidgetTranslation $translations) {
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

    public function getBundle() {
        return null;
    }

    public function getController() {
        return "Post";
    }

    public function getAction() {
        return "listWidget";
    }

    public function getOptions() {
        return array("maximum" => $this->getMaximum());
    }



    /**
     * Set maximum
     *
     * @param string $maximum
     * @return NewsWidget
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
    
        return $this;
    }

    /**
     * Get maximum
     *
     * @return string 
     */
    public function getMaximum()
    {
        
        return $this->maximum;
    }
    
    public function getMethod() {
        return "render";
    }
    
    public function getTemplate(){
        
        return 'HavenCmsBundle:Template:widget.html.twig';
    }
}