<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
* Haven\Bundle\PersonaBundle\Entity\Country
*
* @ORM\Table(name="Country")
* @ORM\Entity
*/
class Country
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
     * @ORM\OneToMany(targetEntity="CountryTranslation", mappedBy="state", cascade={"persist"})
     */
    protected $translations;

        
    /**
    * @var string $abbreviation
    *
    * @ORM\Column(name="abbreviation", type="string", length=3)
    */
    protected $abbreviation;
    
   /**
    * @ORM\OneToMany(targetEntity="State", mappedBy="Country")
    */
    protected $states;

  
    public function __construct()
    {
        $this->states = new ArrayCollection();
  
    }


   /**
    * Get id
    *
    * @return integer
    */
    public function getId()
    {
        return $this->id;
    }

    /**
* Set name
*
* @param string $name
*/
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
* Get name
*
* @return string
*/
    public function getName()
    {
        return $this->name;
    }


    /**
* Get states
*
* @return Doctrine\Common\Collections\Collection
*/
    public function getStates()
    {
        return $this->states;
    }



    public function __toString()
    {
        return $this->abbreviation;
    }


    /**
     * Add states
     *
     * @param Haven\Bundle\PersonaBundle\Entity\State $states
     */
    public function addState(\Haven\Bundle\PersonaBundle\Entity\State $states)
    {
        $this->states[] = $states;
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

    /**
     * Add translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations
     */
    public function addCountryTranslation(\Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations)
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
     * Add translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations
     * @return Country
     */
    public function addTranslation(\Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations)
    {
        $this->translations[] = $translations;
    
        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations
     */
    public function removeTranslation(\Haven\Bundle\PersonaBundle\Entity\CountryTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Remove states
     *
     * @param Haven\Bundle\PersonaBundle\Entity\State $states
     */
    public function removeState(\Haven\Bundle\PersonaBundle\Entity\State $states)
    {
        $this->states->removeElement($states);
    }
}