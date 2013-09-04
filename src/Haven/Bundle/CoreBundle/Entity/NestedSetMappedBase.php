<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;

/**
 * Haven\Bundle\CoreBundle\Entity\NestedSetMappedBase
 *
 * @ORM\MappedSuperclass
 */
abstract class NestedSetMappedBase extends Translatable implements \Haven\Bundle\CoreBundle\Lib\NestedSet\MultipleRootNode {

    /**
     * @ORM\Column(name="lft", type="integer"))
     */
    private $lft;

    /**
     * @ORM\Column(name="rgt", type="integer"))
     */
    private $rgt;

    /**
     * @ORM\Column(name="root", type="integer"))
     */
    private $root;

    /**
     * Set lft
     *
     * @param integer $lft
     * @return NestedSetMappedBase
     */
    public function setLft($lft) {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft() {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return NestedSetMappedBase
     */
    public function setRgt($rgt) {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt() {
        return $this->rgt;
    }



    public function __toString() {
        
        return (string)$this->getLft();
    }

    /**
     * gets Node's left value
     *
     * @return int
     */
    public function getLeftValue() {
        return $this->getLft();
    }

    /**
     * sets Node's left value
     *
     * @param int $lft
     */
    public function setLeftValue($lft) {
        $this->setLft($lft);
    }

    /**
     * gets Node's right value
     *
     * @return int
     */
    public function getRightValue() {
        return $this->getRgt();
    }

    /**
     * sets Node's right value
     *
     * @param int $rgt
     */
    public function setRightValue($rgt) {
        $this->setRgt($rgt);
    }
    /**
     * gets Node's right value
     *
     * @return int
     */
    public function getRootValue() {
        return $this->getRoot();
    }

    /**
     * sets Node's right value
     *
     * @param int $root
     */
    public function setRootValue($root) {
        $this->setRoot($root);
    }


    /**
     * Set root
     *
     * @param integer $root
     * @return NestedSetMappedBase
     */
    public function setRoot($root)
    {
        $this->root = $root;
    
        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }
}