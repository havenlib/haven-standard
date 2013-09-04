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
use Haven\Bundle\CoreBundle\Lib\Locale;
use Haven\Bundle\CoreBundle\Generic\Translatable;

/**
 * Haven\Bundle\CoreBundle\Entity\Language
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\CoreBundle\Repository\LanguageRepository")
 */
class Language extends Translatable {

    const STATUS_INACTIVE = 0;
    const STATUS_PUBLISHED = 1;
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
     * @var integer $rank
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="LanguageTranslation", mappedBy="parent", cascade={"persist"})
     */
    protected $translations;

    /**
     * @ORM\OneToMany(targetEntity="Culture", mappedBy="language", cascade={"persist", "merge"})
     */
    protected $cultures;

    public function __construct() {
        $this->status = false;
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cultures = new \Doctrine\Common\Collections\ArrayCollection();
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
        if (!in_array($status, array(self::STATUS_INACTIVE, self::STATUS_PUBLISHED, self::STATUS_DRAFT))) {
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
     * @param Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations
     */
    public function addLanguageTranslation(\Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations) {
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
     * Add cultures
     *
     * @param Haven\Bundle\CoreBundle\Entity\Culture $cultures
     */
    public function addCulture(\Haven\Bundle\CoreBundle\Entity\Culture $cultures) {
        $this->cultures[] = $cultures;
    }

    /**
     * Get cultures
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCultures() {
        return $this->cultures;
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations
     * @return Language
     */
    public function addTranslation(\Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations) {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\CoreBundle\Entity\LanguageTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    /**
     * Remove cultures
     *
     * @param Haven\Bundle\CoreBundle\Entity\Culture $cultures
     */
    public function removeCulture(\Haven\Bundle\CoreBundle\Entity\Culture $cultures) {
        $this->cultures->removeElement($cultures);
    }

    public function refreshTranslations($languages) {
        $this->addTranslations($languages);
        foreach ($this->getTranslations() as $translation) {
            $translation->setName(Locale::getDisplayLanguage($this->getSymbol(), $translation->getTransLang()->getSymbol()));
        }
    }

    public function refreshMyCulturesTranslations($languages) {
        foreach ($this->getCultures() as $culture) {
            $culture->refreshTranslations($languages);
        }
    }


    /**
     * Set rank
     *
     * @param integer $rank
     * @return Language
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }
}