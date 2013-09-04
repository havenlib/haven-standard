<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Haven\Bundle\PersonaBundle\Entity\Persona
 * @ORM\Entity(repositoryClass="Haven\Bundle\PersonaBundle\Repository\PersonaRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class Persona {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var integer $created_by
     *
     * @ORM\Column(name="created_by", type="integer")
     */
    private $created_by;

    /**
     * @ORM\ManyToMany(targetEntity="Coordinate", inversedBy="persona", cascade={"persist"})
     * @ORM\JoinTable(name="PersonaCoordinate",
     *   joinColumns={@ORM\JoinColumn(name="persona_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="coordinate_id", referencedColumnName="id")})
     */
    private $coordinate;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Persona
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set created_by
     *
     * @param integer $createdBy
     * @return Persona
     */
    public function setCreatedBy($createdBy) {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return integer 
     */
    public function getCreatedBy() {
        return $this->created_by;
    }

    /**
     * Add coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addCoordinate(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->coordinate[] = $coordinate;

        return $this;
    }

    /**
     * Remove coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removeCoordinate(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->coordinate->removeElement($coordinate);
    }

    /**
     * Get coordinate
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCoordinate() {
        return $this->coordinate;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->coordinate = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setCreatedBy("1");
    }

    /**
     * Add map
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addMap(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        return $this->addCoordinate($coordinate);
    }

    /**
     * Remove map
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removeMap(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->removeCoordinate($coordinate);
    }

    /**
     * Get map
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMap() {
        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Map";
                        })->getValues());

        return $return_collection;
    }

    /**
     * Add coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addPostal(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        return $this->addCoordinate($coordinate);
    }

    /**
     * Remove coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removePostal(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->removeCoordinate($coordinate);
    }

    /**
     * Get coordinate
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPostal() {
        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Postal";
                        })->getValues());

        return $return_collection;
    }

    /**
     * Add coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addWeb(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        return $this->addCoordinate($coordinate);
    }

    /**
     * Remove coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removeWeb(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->removeCoordinate($coordinate);
    }

    /**
     * Get coordinate
     * @Assert\Valid()
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWeb() {
        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Web";
                        })->getValues());

        return $return_collection;
    }

    /**
     * Add coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addTelephone(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        return $this->addCoordinate($coordinate);
    }

    /**
     * Remove coordinate
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removeTelephone(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->removeCoordinate($coordinate);
    }

    /**
     * Get coordinate
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTelephone() {
        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Telephone";
                        })->getValues());

        return $return_collection;
    }

//
//    /**
//     * Add coordinate
//     *
//     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
//     * @return Persona
//     */
//    public function addCell(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
//        return $this->addCoordinate($coordinate);
//    }
//
//    /**
//     * Remove coordinate
//     *
//     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
//     */
//    public function removeCell(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
//        $this->removeCoordinate($coordinate);
//    }
//
//    /**
//     * Get coordinate
//     * @return Doctrine\Common\Collections\Collection 
//     */
//    public function getCell() {
//        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
//                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Cell";
//                        })->getValues());
//
//        return $return_collection;
//    }
//
//    /**
//     * Add coordinate
//     *
//     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
//     * @return Persona
//     */
//    public function addFax(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
//        return $this->addCoordinate($coordinate);
//    }
//
//    /**
//     * Remove coordinate
//     *
//     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
//     */
//    public function removeFax(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
//        $this->removeCoordinate($coordinate);
//    }
//
//    /**
//     * Get coordinate
//     * @return Doctrine\Common\Collections\Collection 
//     */
//    public function getFax() {
//        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
//                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Fax";
//                        })->getValues());
//
//        return $return_collection;
//    }

    /**
     * Add time
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     * @return Persona
     */
    public function addTime(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        return $this->addCoordinate($coordinate);
    }

    /**
     * Remove time
     *
     * @param Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate
     */
    public function removeTime(\Haven\Bundle\PersonaBundle\Entity\Coordinate $coordinate) {
        $this->removeCoordinate($coordinate);
    }

    /**
     * Get time
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTime() {
        $return_collection = new \Doctrine\Common\Collections\ArrayCollection($this->getCoordinate()->filter(function ($coordinate) {
                            return get_class($coordinate) == "Haven\Bundle\PersonaBundle\Entity\Time";
                        })->getValues());

        return $return_collection;
    }

}