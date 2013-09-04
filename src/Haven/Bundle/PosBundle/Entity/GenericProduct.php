<?php

namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Haven\Bundle\PosBundle\Entity\GenericTranslation;
use Haven\Bundle\CoreBundle\Generic\Translatable;

/**
 *  Haven\Bundle\PosBundle\Entity\Generic
 * 
 *  @ORM\Entity(repositoryClass="Haven\Bundle\CoreBundle\Generic\StatusRepository")
 */
class GenericProduct extends Product {

    /**
     * @ORM\OneToMany(targetEntity="GenericProductTranslation", mappedBy="parent", cascade={"persist"})
     */
    private $translations;

    protected function getTranslationClass() {
        return "Haven\Bundle\PosBundle\Entity\GenericProductTranslation";
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
     * @param Haven\Bundle\PosBundle\Entity\GenericProductTranslation $translations
     * @return GenericProduct
     */
    public function addTranslation(\Haven\Bundle\PosBundle\Entity\GenericProductTranslation $translations) {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\PosBundle\Entity\GenericProductTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\PosBundle\Entity\GenericProductTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTranslations() {
        return $this->translations;
    }

    public function getName($lang = null) {
        return $this->getTranslated('Name', $lang);
    }

    /**
     * Description must return an overall description of the product,
     * For non-generic it should return a concatenation of other descriptive fields,
     * @param type $lang
     * @return type
     */
    public function getDescription($lang = null) {
        return $this->getTranslated('Description', $lang);
    }

}