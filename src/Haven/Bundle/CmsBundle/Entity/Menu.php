<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Haven\Bundle\CoreBundle\Entity\NestedSetMappedBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\CmsBundle\Repository\MenuRepository")
 */
class Menu extends NestedSetMappedBase {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="MenuTranslation", mappedBy="parent", cascade={"persist", "remove"})
     */
    protected $translations;

    public function getName($language = null) {
        return $this->getTranslated("Name", $language);
    }

    public function getLink($language = null) {
        return $this->getTranslated("Link", $language);
    }

    public function getSlug($language = null) {
        return $this->getTranslated("Slug", $language);
    }

    public function getFullSlug($language = null) {
        return $this->getTranslated("FullSlug", $language);
    }

    /**
     * Constructor
     */
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
     * Set type
     *
     * @param string $type
     * @return Menu
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Add translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\MenuTranslation $translations
     * @return Menu
     */
    public function addTranslation(\Haven\Bundle\CmsBundle\Entity\MenuTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Haven\Bundle\CmsBundle\Entity\MenuTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\CmsBundle\Entity\MenuTranslation $translations) {
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
}