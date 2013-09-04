<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;

/**
 * MenuTranslation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MenuTranslation extends TranslationMappedBase {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $slug
     * @ORM\Column(name="slug", type="string", length=1024, nullable=true)
     */
    private $slug;    

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="\Haven\Bundle\CoreBundle\Entity\Link", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="link_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="translations")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent;    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return MenuTranslation
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink() {
        return $this->link;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return MenuTranslation
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
     * Set parent
     *
     * @param \Haven\Bundle\CmsBundle\Entity\Menu $parent
     * @return MenuTranslation
     */
    public function setParent(\Haven\Bundle\CmsBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Haven\Bundle\CmsBundle\Entity\Menu 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return MenuTranslation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        $array = explode("/", $this->slug);
        
        return end($array);
    }

    public function getFullSlug()
    {
        return $this->slug;
    }
}