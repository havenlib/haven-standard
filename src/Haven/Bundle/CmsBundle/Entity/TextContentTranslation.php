<?php

namespace Haven\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;

/**
 * TextContentTranslation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TextContentTranslation extends TranslationMappedBase {

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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="TextContent", inversedBy="translations")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
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
     * Set content
     *
     * @param string $content
     * @return TextContentTranslation
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }


    /**
     * Set parent
     *
     * @param \Haven\Bundle\CmsBundle\Entity\TextContent $parent
     * @return TextContentTranslation
     */
    public function setParent(\Haven\Bundle\CmsBundle\Entity\TextContent $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Haven\Bundle\CmsBundle\Entity\TextContent 
     */
    public function getParent()
    {
        return $this->parent;
    }
}