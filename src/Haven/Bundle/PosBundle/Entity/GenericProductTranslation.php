<?php

namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\PosBundle\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;
/**
 * Haven\Bundle\PosBundle\Entity\GenericTranslation
 *
 * @ORM\Entity()
 */
class GenericProductTranslation extends TranslationMappedBase
{
        /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var text $name
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="GenericProduct", inversedBy="translations")
     * @ORM\JoinColumn(name="faq_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;
    

    /**
     * Set name
     *
     * @param string $name
     * @return GenericProductTranslation
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return GenericProductTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set parent
     *
     * @param Haven\Bundle\PosBundle\Entity\GenericProduct $parent
     * @return GenericProductTranslation
     */
    public function setParent(\Haven\Bundle\PosBundle\Entity\GenericProduct $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return Haven\Bundle\PosBundle\Entity\GenericProduct 
     */
    public function getParent()
    {
        return $this->parent;
    }
}