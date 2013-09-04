<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\CoreBundle\Generic\Translatable;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category extends Translatable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="CategoryTranslation", mappedBy="parent", cascade={"persist"})
     */
    protected $translations;

    /**
     * @ORM\ManyToMany(targetEntity="\Haven\Bundle\WebBundle\Entity\Post", mappedBy="categories", cascade={"persist"})
     */
    protected $posts;

    /**
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="my_categories")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="categories")
     * @ORM\JoinTable(name="Categories",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="my_category_id", referencedColumnName="id")}
     *      )
     */
    private $my_categories;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getName($lang = null) {
        return $this->getTranslated('Name', $lang);
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translations
     *
     * @param \Haven\Bundle\CoreBundle\Entity\CategoryTranslation $translation
     * @return Category
     */
    public function addTranslation(\Haven\Bundle\CoreBundle\Entity\CategoryTranslation $translation) {
        $translation->setParent($this);
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Haven\Bundle\CoreBundle\Entity\CategoryTranslation $translation
     */
    public function removeTranslation(\Haven\Bundle\CoreBundle\Entity\CategoryTranslation $translation) {
        $this->translations->removeElement($translation);
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
     * Add posts
     *
     * @param \Haven\Bundle\WebBundle\Entity\Post $post
     * @return Category
     */
    public function addPost(\Haven\Bundle\WebBundle\Entity\Post $post) {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Haven\Bundle\WebBundle\Entity\Post $post
     */
    public function removePost(\Haven\Bundle\WebBundle\Entity\Post $post) {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts() {
        return $this->posts;
    }

    public function __toString() {
        return $this->getName()? $this->getName(): "" ;
    }

    /**
     * Add categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     * @return Category
     */
    public function addCategory(\Haven\Bundle\CoreBundle\Entity\Category $category) {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $category
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
     * Add my_categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $myCategories
     * @return Category
     */
    public function addMyCategory(\Haven\Bundle\CoreBundle\Entity\Category $myCategory) {
        $this->my_categories[] = $myCategory;

        return $this;
    }

    /**
     * Remove my_categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $myCategories
     */
    public function removeMyCategory(\Haven\Bundle\CoreBundle\Entity\Category $myCategory) {
        $this->my_categories->removeElement($myCategory);
    }

    /**
     * Get my_categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyCategories() {
        return $this->my_categories;
    }


    /**
     * Add categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     * @return Category
     */
    public function addCategorie(\Haven\Bundle\CoreBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $categories
     */
    public function removeCategorie(\Haven\Bundle\CoreBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Add my_categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $myCategories
     * @return Category
     */
    public function addMyCategorie(\Haven\Bundle\CoreBundle\Entity\Category $myCategories)
    {
        $this->my_categories[] = $myCategories;
    
        return $this;
    }

    /**
     * Remove my_categories
     *
     * @param \Haven\Bundle\CoreBundle\Entity\Category $myCategories
     */
    public function removeMyCategorie(\Haven\Bundle\CoreBundle\Entity\Category $myCategories)
    {
        $this->my_categories->removeElement($myCategories);
    }
}