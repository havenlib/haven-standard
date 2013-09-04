<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Widget
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Widget extends Content {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     */
    protected $status;

    /**
     * @var \Haven\Bundle\CmsBundle\Entity\Page
     */
    protected $page;

    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param boolean $status
     * @return Widget
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
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
     * Set page
     *
     * @param \Haven\Bundle\CmsBundle\Entity\Page $page
     * @return Widget
     */
    public function setPage(\Haven\Bundle\CmsBundle\Entity\Page $page = null) {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Haven\Bundle\CmsBundle\Entity\Page 
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Get bundle
     *
     * @return string 
     */
    public function getBundle() {
        throw new \Exception("You must implement " . __FUNCTION__ . " function in " . get_called_class());
    }

    /**
     * Get controller
     *
     * @return string 
     */
    public function getController() {
        throw new \Exception("You must implement " . __FUNCTION__ . " function in " . get_called_class());
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction() {
        throw new \Exception("You must implement " . __FUNCTION__ . " function in " . get_called_class());
    }

}