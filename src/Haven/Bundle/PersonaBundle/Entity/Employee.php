<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Haven\Bundle\PersonaBundle\Entity\Persona;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Employee extends Persona {

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=128, unique=false)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=128, unique=false)
     */
    private $lastname;

    /**
     * @var string $sex
     *
     * @ORM\Column(name="sex", type="string")
     */
    private $sex;

    /**
     * @ORM\OneToOne(targetEntity="Haven\Bundle\SecurityBundle\Entity\User", mappedBy="persona",cascade={"all"})
     */
    private $user;

    /**
     * @var string $slug
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Employee
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Employee
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     * @return Employee
     */
    public function setSex($sex) {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return integer 
     */
    public function getSex() {
        return $this->sex;
    }

    /**
     * Set user
     *
     * @param \Haven\Bundle\SecurityBundle\Entity\User $user
     * @return Employee
     */
    public function setUser(\Haven\Bundle\SecurityBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Haven\Bundle\SecurityBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Employee
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    public function getFullname() {
        return $this->getFirstname() . " " . $this->getLastname();
    }

}