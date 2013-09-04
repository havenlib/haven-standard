<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Haven\Bundle\PersonaBundle\Entity\Coordinate
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="plane", type="string")
 * @ORM\DiscriminatorMap({
    * "telephone"="Haven\Bundle\PersonaBundle\Entity\Telephone", 
    * "map"="Haven\Bundle\PersonaBundle\Entity\Map", 
    * "time"="Haven\Bundle\PersonaBundle\Entity\Time", 
    * "web"="Haven\Bundle\PersonaBundle\Entity\Web", 
    * "postal"="Haven\Bundle\PersonaBundle\Entity\Postal"
 * })
 */
class Coordinate {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     * @var master
//     * 
//     * @ORM\Column(name="master", type="string", length=256)
//     */
//    private $master;

    /**
     * @ORM\ManyToMany(targetEntity="Persona", mappedBy="coordinate", cascade={"persist"})
     * @ORM\JoinTable(name="PersonaCoordinate")
     */
    private $persona;

    public function getPlane() {
        return get_called_class();
    }

    public function __construct() {
        $this->contact = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add persona
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Persona $persona
     * @return Coordinate
     */
    public function addPersona(\Haven\Bundle\PersonaBundle\Entity\Persona $persona) {
        $this->persona[] = $persona;

        return $this;
    }

    /**
     * Remove persona
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Persona $persona
     */
    public function removePersona(\Haven\Bundle\PersonaBundle\Entity\Persona $persona) {
        $this->persona->removeElement($persona);
    }

    /**
     * Get persona
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPersona() {
        return $this->persona;
    }

}