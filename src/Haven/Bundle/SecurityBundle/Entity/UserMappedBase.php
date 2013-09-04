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

// Symfony includes
use Symfony\Component\Security\Core\User\UserInterface;
// Doctrine includes
use Doctrine\ORM\Mapping as ORM;


/**
 * Haven\Bundle\SecurityBundle\Entity\UserMappedBase
 *
 * @ORM\MappedSuperclass
 */
class UserMappedBase{

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=128, unique=true)
     */
    private $username;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=64, unique=true)
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var boolean $locked
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

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

    public function __construct() {
        $this->created_at = new \DateTime();
        $this->created_by = "Default";
        $this->status = true;
        $this->locked = false;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set created_by
     *
     * @param integer $createdBy
     */
    public function setCreatedBy($createdBy) {
        $this->created_by = $createdBy;
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
     * @inheritDoc
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked) {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked() {
        return $this->locked;
    }

    /**
     * Set status
     *
     * @param boolean $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array('ROLE_USER', 'ROLE_Admin');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user) {
        return $this->username === $user->getUsername();
    }
}