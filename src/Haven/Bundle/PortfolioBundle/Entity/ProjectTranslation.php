<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Entity\SluggableMappedBase;

/**
 * Haven\Bundle\PortfolioBundle\Entity\ProjectTranslation
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ProjectTranslation extends SluggableMappedBase {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="translations")
     * @ORM\JoinColumn(name="foglio_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * Set name
     *
     * @param string $name
     * @return ProjectTranslation
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

    /**
     * Set description
     *
     * @param string $description
     * @return ProjectTranslation
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set parent
     *
     * @param \Haven\Bundle\PortfolioBundle\Entity\Project $parent
     * @return ProjectTranslation
     */
    public function setParent(\Haven\Bundle\PortfolioBundle\Entity\Project $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Haven\Bundle\PortfolioBundle\Entity\Project 
     */
    public function getParent() {
        return $this->parent;
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
}