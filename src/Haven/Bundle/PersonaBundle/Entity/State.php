<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Haven\Bundle\PersonaBundle\Entity\StateTranslation;

/**
* Haven\Bundle\PersonaBundle\Entity\State
*
* @ORM\Table(name="State")
* @ORM\Entity
*/
class State
{
   /**
    * @var integer $id
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="StateTranslation", mappedBy="state", cascade={"persist"})
     */
    protected $translations;
    
    /**
    * @var string $abbreviation
    *
    * @ORM\Column(name="abbreviation", type="string", length=3)
    */
    protected $abbreviation;


   /**
    * @ORM\ManyToOne(targetEntity="Country", inversedBy="states")
    * @ORM\JoinColumn(name="Country_id", referencedColumnName="id")
    */
    protected $Country;


    /**
* Get id
*
* @return integer
*/
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
        return $this->getNameTrans();
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * Get abbreviation
     *
     * @return string 
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
    
    /**
     * Add translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations
     */
    public function addStateTranslation(\Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations)
    {
        $this->translations[] = $translations;
    }

    /**
     * Get translations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * use a filter to filter the language to current
     * @return string
     */
    public function getNameTrans(){
        $lang = \Locale::getPrimaryLanguage(\Locale::getDefault());
        return $this->translations->filter(function ($translation) use ($lang) {return $translation->getLang() == $lang;} )->first()->getName();
    }
    
 

    /**
     * Set Country
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Country $country
     */
    public function setCountry(\Haven\Bundle\PersonaBundle\Entity\Country $country)
    {
        $this->Country = $country;
    }

    /**
     * Get Country
     *
     * @return Haven\Bundle\PersonaBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations
     * @return State
     */
    public function addTranslation(\Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations)
    {
        $this->translations[] = $translations;
    
        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\PersonaBundle\Entity\StateTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}