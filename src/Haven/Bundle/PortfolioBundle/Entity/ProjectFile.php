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

/**
 * ProjectFile
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ProjectFile {

    const STATUS_INACTIVE = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="project", inversedBy="projectFiles")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $project;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Haven\Bundle\MediaBundle\Entity\File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    private $file;

    public function __construct() {
        
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
     * Set project
     *
     * @param \Haven\Bundle\PortfolioBundle\Entity\project $project
     * @return ProjectFile
     */
    public function setProject(\Haven\Bundle\PortfolioBundle\Entity\project $project = null) {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Haven\Bundle\PortfolioBundle\Entity\project 
     */
    public function getProject() {
        return $this->project;
    }


    

    /**
     * Set file
     *
     * @param \Haven\Bundle\MediaBundle\Entity\File $file
     * @return ProjectFile
     */
    public function setFile(\Haven\Bundle\MediaBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Haven\Bundle\MediaBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }
}