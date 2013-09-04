<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;
use Doctrine\Common\Annotations\AnnotationReader;
use \ReflectionClass;

/**
 * Haven\Bundle\PosBundle\Entity\Products
 *
 * @ORM\Entity(repositoryClass="Haven\Bundle\PosBundle\Repository\ProductRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="plane", type="string")
 */
class Product extends Translatable implements \Serializable {

    const STATUS_INACTIVE = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    /**
     * @var integer $id 
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var decimal $price
     * @ORM\Column(name="price" , type="decimal", scale=2)
     */
    private $price;

    /**
     * @var boolean $status
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice($format = null, $locale = null) {
        if ($format) {
            if ($locale) {
                setlocale(LC_MONETARY, $locale);
            }
            return money_format("%" . $format, $this->price);
        }
        return $this->price;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Product
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

    public function serialize() {
        $data["id"] = $this->id;
        $data["status"] = $this->getStatus();
        $data["price"] = $this->getPrice();
        return serialize($data);
    }

    public function unserialize($data) {
        $data = unserialize($data);
        $this->id = $data["id"];
        $this->setStatus($data["status"]);
        $this->setPrice($data["price"]);
    }

    protected function getName() {
        throw new \Exception("Every product type should have a name and a description function " . get_called_class());
    }

    public function getDescription() {
        throw new \Exception("Every product type should have a name and a description function " . get_called_class());
    }

    public static function getDiscriminatorMap() {
        $reader = new AnnotationReader();
        return $reader->getClassAnnotation(new ReflectionClass(__CLASS__), "\Doctrine\ORM\Mapping\DiscriminatorMap");
    }

}