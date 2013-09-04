<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Haven\Bundle\WebBundle\Entity\Faq
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\WebBundle\Repository\FaqRepository")
 */
class Faq extends Translatable {

    const STATUS_INACTIVE = 0;
    const STATUS_PUBLISHED = 1;

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
     * @var integer $rank
     *
     * @ORM\Column(name="rank", type="integer", length=255, nullable = true)
     */
    private $rank;

    /**
     * 
     * @ORM\OneToMany(targetEntity="FaqTranslation", mappedBy="parent", cascade={"persist"})
     * @Assert\Valid
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
     * Set status
     *
     * @param boolean $status
     */
    public function setStatus($status) {
        if (!in_array($status, array(self::STATUS_INACTIVE, self::STATUS_PUBLISHED))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
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
     * @param Haven\Bundle\WebBundle\Entity\FaqTranslation $translations
     */
    public function addFaqTranslation(\Haven\Bundle\WebBundle\Entity\FaqTranslation $translations) {
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

    public function getResponse($lang = null) {
        return $this->getTranslated('Response', $lang);
    }

    public function getQuestion($lang = null) {
        return $this->getTranslated('Question', $lang);
    }

    /**
     * Set rank
     *
     * @param string $rank
     */
    public function setRank($rank) {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank() {
        return $this->rank;
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\WebBundle\Entity\FaqTranslation $translations
     * @return Faq
     */
    public function addTranslation(\Haven\Bundle\WebBundle\Entity\FaqTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\WebBundle\Entity\FaqTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\WebBundle\Entity\FaqTranslation $translations) {
        $this->translations->removeElement($translations);
    }

}