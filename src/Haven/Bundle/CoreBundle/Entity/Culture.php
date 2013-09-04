<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;

/**
 * Haven\Bundle\CoreBundle\Entity\Culture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\CoreBundle\Generic\StatusRepository")
 */
class Culture extends Translatable {
    const STATUS_INACTIVE = 0;
    const STATUS_PUBLISH = 1;
    const STATUS_DRAFT = 2;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $symbol
     *
     * @ORM\Column(name="symbol", type="string", length=8)
     */
    private $symbol;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     *
     * @ORM\OneToMany(targetEntity="CultureTranslation", mappedBy="parent", cascade={"persist"})
     */
    protected $translations;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="cultures")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $language;

    public function __construct() {
        $this->status = false;
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
     * Set symbol
     *
     * @param string $symbol
     */
    public function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol() {
        return $this->symbol;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status) {
        if (!in_array($status, array(self::STATUS_INACTIVE, self::STATUS_PUBLISH, self::STATUS_DRAFT))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }

    public function getName($lang = null) {
        return $this->getTranslated('Name', $lang);
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations
     */
    public function addCultureTranslation(\Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations) {
        $this->translations[] = $translations;
    }

    /**
     * Get translations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTranslations() {
        return $this->translations;
    }


    /**
     * Set language
     *
     * @param Haven\Bundle\CoreBundle\Entity\Language $language
     */
    public function setLanguage(\Haven\Bundle\CoreBundle\Entity\Language $language) {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return Haven\Bundle\CoreBundle\Entity\Language 
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations
     * @return Culture
     */
    public function addTranslation(\Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations) {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\CoreBundle\Entity\CultureTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    public function refreshTranslations($languages) {
        $this->addTranslations($languages);
        foreach ($this->getTranslations() as $translation) {
            $translation->setName(\Locale::getDisplayRegion($this->getSymbol(), $translation->getTransLang()->getSymbol()));
        }
    }

}