<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\MediaBundle\Entity\File;

/**
 * @ORM\Entity()
 */
class ImageFile extends File {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer $width
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer $height
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var text $alt
     * 
     * @ORM\Column(name="alt", type="text", nullable=true)
     */
    protected $alt;

    /**
     * Set width
     *
     * @param integer $width
     * @return ImageFile
     */
    public function setWidth($width) {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return ImageFile
     */
    public function setHeight($height) {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return ImageFile
     */
    public function setAlt($alt) {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt() {
        return $this->alt;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}