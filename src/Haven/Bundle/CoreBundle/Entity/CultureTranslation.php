<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;

/**
 * Haven\Bundle\CoreBundle\Entity\CultureTranslation
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class CultureTranslation extends TranslationMappedBase {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Culture", inversedBy="translations")
     * @ORM\JoinColumn(name="culture_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param Haven\Bundle\CoreBundle\Entity\Culture $parent
     */
    public function setParent(\Haven\Bundle\CoreBundle\Entity\Culture $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Haven\Bundle\CoreBundle\Entity\Culture 
     */
    public function getParent()
    {
        return $this->parent;
    }
}