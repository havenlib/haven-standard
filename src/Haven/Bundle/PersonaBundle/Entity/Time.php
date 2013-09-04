<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tahua\SiteBundle\Entity\Time
 *
 * @ORM\Entity()
 */
class Time extends Coordinate{
  
    /**
     * @ORM\Column(name="moment", type="datetime", nullable=true)
     */
    protected $moment;
    

    public function __construct() {
        $this->moment = new \DateTime();
    }

    /**
     * Set moment
     *
     * @param datetime $moment
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;
    }

    /**
     * Get moment
     *
     * @return datetime 
     */
    public function getMoment()
    {
        return $this->moment;
    }
    
}