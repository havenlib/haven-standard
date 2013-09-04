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
use Haven\Bundle\CoreBundle\Generic\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\PortfolioBundle\Repository\ProjectRepository")
 */
class Project extends Translatable {

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     *
     * @var type 
     * @ORM\Column(name="author", type="string")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    protected $status;
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="ProjectFile", mappedBy="project")
     */
    protected $projectFiles;
    /**
     * 
     * @ORM\OneToMany(targetEntity="ProjectTranslation", mappedBy="parent", cascade={"persist"})
     * @Assert\Valid
     */
    protected $translations;

    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projectFiles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Project
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Project
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getDescription($lang = null) {
        return $this->getTranslated('description', $lang);
    }

    public function getName($lang = null) {
        return $this->getTranslated('name', $lang);
    }

    /**
     * Add translations
     *
     * @param ProjectTranslation $translations
     * @return Project
     */
    public function addTranslation(ProjectTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param ProjectTranslation $translations
     */
    public function removeTranslation(ProjectTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Project
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

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations() {
        return $this->translations;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Project
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Project
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add projectFiles
     *
     * @param \Haven\Bundle\PortfolioBundle\Entity\ProjectFile $projectFiles
     * @return Project
     */
    public function addProjectFile(\Haven\Bundle\PortfolioBundle\Entity\ProjectFile $projectFiles)
    {
        $this->projectFiles[] = $projectFiles;
    
        return $this;
    }

    /**
     * Remove projectFiles
     *
     * @param \Haven\Bundle\PortfolioBundle\Entity\ProjectFile $projectFiles
     */
    public function removeProjectFile(\Haven\Bundle\PortfolioBundle\Entity\ProjectFile $projectFiles)
    {
        $this->projectFiles->removeElement($projectFiles);
    }

    /**
     * Get projectFiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjectFiles()
    {
        return $this->projectFiles;
    }
}