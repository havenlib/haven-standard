<?php

namespace Haven\Bundle\PersonaBundle\Entity;

use Haven\Bundle\PersonaBundle\Entity\State;
use Doctrine\ORM\Mapping as ORM;

/**
 * Haven\Bundle\PersonaBundle\Entity\StateTranslation
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class StateTranslation {
    
   /**
    * @var integer $id
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
    * @var string $name
    *
    * @ORM\Column(name="name", type="string", length=255)
    */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="State", inversedBy="translations")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", onDelete="CASCADE")
     */ 
    protected $state;
    
    /**
     *
     * @var type $lang
     * 
     * @ORM\Column(name="lang", type="text")
     */
    protected $lang;
    
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
     * Set state
     *
     * @param Haven\Bundle\PersonaBundle\Entity\State $state
     */
    public function setState(\Haven\Bundle\PersonaBundle\Entity\State $state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return Haven\Bundle\PersonaBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
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
     * Set lang
     *
     * @param text $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Get lang
     *
     * @return text 
     */
    public function getLang()
    {
        return $this->lang;
    }
}