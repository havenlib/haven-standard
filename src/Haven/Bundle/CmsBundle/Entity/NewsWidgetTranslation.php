<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;

/**
 * NewsWidgetTranslation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NewsWidgetTranslation extends TranslationMappedBase {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="string", type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="NewsWidget", inversedBy="translations")
     * @ORM\JoinColumn(name="widget_id", referencedColumnName="id", onDelete="CASCADE")
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
     * Set parent
     *
     * @param \Haven\Bundle\CmsBundle\Entity\Widget $parent
     * @return WidgetTranslation
     */
    public function setParent(\Haven\Bundle\CmsBundle\Entity\Widget $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Haven\Bundle\CmsBundle\Entity\Widget 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return WidgetTranslation
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

}