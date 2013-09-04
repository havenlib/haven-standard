<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\SecurityBundle\Entity;

// Doctrine includes
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of confirmation
 * Haven\Bundle\SecurityBundle\Entity\UserReset
 * @ORM\Table(name="UserReset")
 * @ORM\Entity()
 * @author themaster
 */
class UserReset {

    /**
     * @ORM\OneToOne(targetEntity="Haven\Bundle\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",  onDelete="CASCADE")
     */
    private $user;

    /**
     * var string $uuid
     * @ORM\Id  @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="uuid", type="string", length=255, unique=true, nullable=false)
     */
    private $uuid;

    /**
     * var string $confirmation
     * @ORM\Column(name="confirmation", type="string", length=128, unique=true, nullable=false)
     */
    private $confirmation;

    public function __construct() {
        $this->uuid = md5(uniqid());
        $this->confirmation = uniqid();
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     */
    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid() {
        return $this->uuid;
    }

    /**
     * Set confirmation
     *
     * @param string $confirmation
     */
    public function setConfirmation($confirmation) {
        $this->confirmation = $confirmation;
    }

    /**
     * Get confirmation
     *
     * @return string 
     */
    public function getConfirmation() {
        return $this->confirmation;
    }

    /**
     * Set user
     *
     * @param Haven\Bundle\SecurityBundle\Entity\User $user
     */
    public function setUser(\Haven\Bundle\SecurityBundle\Entity\User $user) {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Haven\Bundle\SecurityBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

}