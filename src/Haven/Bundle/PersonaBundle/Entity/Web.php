<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tahua\SiteBundle\Entity\Web
 *
 * @ORM\Entity()
 */
class Web extends Coordinate{
     /**
     * @ORM\Column(name="web", type="string", length=512)
     */
    protected $web;
    
    /**
     * @ORM\Column(name="type", type="string", length=48)
     */
    protected $type;




    /**
     * Set web
     *
     * @param string $web
     */
    public function setWeb($web)
    {
        $this->web = $web;
    }

    /**
     * Get web
     *
     * @return string 
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}