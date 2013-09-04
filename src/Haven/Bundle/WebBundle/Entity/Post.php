<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Haven\Bundle\WebBundle\Entity\Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Haven\Bundle\WebBundle\Repository\PostRepository")
 */
class Post extends Translatable {

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
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var integer $rank
     *
     * @ORM\Column(name="rank", type="integer", length=255, nullable = true)
     */
    private $rank;

    /**
     * @var datetime $postbegin_at
     *
     * @ORM\Column(name="postbegin_at", type="datetime", nullable = true)
     */
    private $postbegin_at;

    /**
     * @var datetime $postend_at
     *
     * @ORM\Column(name="postend_at", type="date", nullable = true)
     */
    private $postend_at;

    /**
     * @ORM\OneToMany(targetEntity="PostTranslation", mappedBy="parent", cascade={"persist"})
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @ORM\ManyToMany(targetEntity="\Haven\Bundle\CoreBundle\Entity\Category", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinTable(name="PostsCatgories")
     */
    protected $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Haven\Bundle\MediaBundle\Entity\File")
     * @ORM\JoinTable(name="PostsFiles",
     * joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")})
     */
    public $files;

    public function __construct() {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt($format = null) {
        return $format ? $this->getFormated($this->created_at, $format) : $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt($format = null) {
        return $format ? $this->getFormated($this->updated_at, $format) : $this->updated_at;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status) {
        if (!in_array($status, array(self::STATUS_INACTIVE, self::STATUS_PUBLISHED, self::STATUS_DRAFT))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set postbegin_at
     *
     * @param datetime $postbeginAt
     */
    public function setPostbeginAt($postbeginAt) {
        $this->postbegin_at = $postbeginAt;
    }

    /**
     * Get postbegin_at
     *
     * @return datetime
     */
    public function getPostbeginAt($format = null) {
        return $format ? $this->getFormated($this->postbegin_at, $format) : $this->postbegin_at;
    }

    /**
     * Set postend_at
     *
     * @param datetime $postendAt
     */
    public function setPostendAt($postendAt) {
        $this->postend_at = $postendAt;
    }

    /**
     * Get postend_at
     *
     * @return datetime
     */
    public function getPostendAt($format = null) {
        return $format ? $this->getFormated($this->postend_at, $format) : $this->postend_at;
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\WebBundle\Entity\PostTranslation $translations
     */
    public function addPostTranslation(PostTranslation $translations) {
        $this->translations[] = $translations;
    }

    /**
     * Get translations
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTranslations() {
        return $this->translations;
    }

    public function getContent($lang = null) {
        return $this->getTranslated('content', $lang);
    }

    public function getTitle($lang = null) {
        return $this->getTranslated('title', $lang);
    }

    public function getSubtitle($lang = null) {
        return $this->getTranslated('subtitle', $lang);
    }

    public function getExcerpt($lang = null) {
        return $this->getTranslated('excerpt', $lang);
    }

    public function getSlug($lang = null) {
        return $this->getTranslated('slug', $lang);
    }

    private function getFormated($date, $format) {
        return $date ? strftime($format, $date->getTimestamp()) : "";
    }

    /**
     * Add translations
     *
     * @param Haven\Bundle\WebBundle\Entity\PostTranslation $translations
     * @return Post
     */
    public function addTranslation(PostTranslation $translations) {
        $translations->setParent($this);
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param Haven\Bundle\WebBundle\Entity\PostTranslation $translations
     */
    public function removeTranslation(PostTranslation $translations) {
        $this->translations->removeElement($translations);
    }

    /**
     * Add categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     * @return Post
     */
    public function addCategory(\Haven\Bundle\CoreBundle\Entity\Category $category) {
        $category->addPost($this);
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     */
    public function removeCategory(\Haven\Bundle\CoreBundle\Entity\Category $category) {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Add categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     * @return Post
     */
    public function addCategorie(\Haven\Bundle\CoreBundle\Entity\Category $categories) {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     */
    public function removeCategorie(\Haven\Bundle\CoreBundle\Entity\Category $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Set rank
     *
     * @param string $rank
     * @return Post
     */
    public function setRank($rank) {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank() {
        return $this->rank;
    }


    /**
     * Add files
     *
     * @param \Haven\Bundle\MediaBundle\Entity\File $files
     * @return Post
     */
    public function addFile(\Haven\Bundle\MediaBundle\Entity\File $files)
    {
        $this->files[] = $files;
    
        return $this;
    }

    /**
     * Remove files
     *
     * @param \Haven\Bundle\MediaBundle\Entity\File $files
     */
    public function removeFile(\Haven\Bundle\MediaBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }
}