<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Haven\Bundle\PersonaBundle\Entity\Address
 *
 * @ORM\Entity
 */
class Map extends Coordinate {
    /**
     * @Assert\NotBlank
     * @ORM\Column(name="lng", type="integer", length=255)
     */
    protected $lng;
    
    /**
     * @ORM\Column(name="lat", type="integer", length=255)
     */
    protected $lat;



    /**
     * Set lng
     *
     * @param integer $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * Get lng
     *
     * @return integer 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lat
     *
     * @param integer $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Get lat
     *
     * @return integer 
     */
    public function getLat()
    {
        return $this->lat;
    }
}