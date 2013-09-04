<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Haven\Bundle\PersonaBundle\Entity\Postal
 *
 * @ORM\Entity
 */
class Postal extends Coordinate {

     /**
     * @Assert\NotBlank
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    protected $address;
    
    /**
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    protected $address2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    protected $country;
    /**
     * @var string $postal_code
     * @Assert\NotBlank
     * @ORM\Column(name="postal_code", type="string", length=12, nullable=true)
     */
    protected $postal_code;
    /**
     * @var string $city
     * @Assert\NotBlank
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=true)
     */
    protected $state;   

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postal_code
     *
     * @param string $postal_code
     * @return Postal
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    
        return $this;
    }

    /**
     * Get postal_code
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set country
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Country $country
     * @return Postal
     */
    public function setCountry(\Haven\Bundle\PersonaBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return Haven\Bundle\PersonaBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state
     *
     * @param Haven\Bundle\PersonaBundle\Entity\State $state
     * @return Postal
     */
    public function setState(\Haven\Bundle\PersonaBundle\Entity\State $state = null)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return Haven\Bundle\PersonaBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
    }
}