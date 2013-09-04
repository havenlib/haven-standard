<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Haven\Bundle\PersonaBundle\Entity\Telephone
 *
 * @ORM\Entity()
 */
class Telephone extends Coordinate{
 
    /**
     * @ORM\Column(name="telephone", type="integer", nullable=true)
     */
    protected $telephone;
    
    /**
     * @ORM\Column(name="type", type="string", length=48)
     */
    protected $type;




    /**
     * Set telephone
     *
     * @param integer $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return integer 
     */
    public function getTelephone()
    {
        return $this->telephone;
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