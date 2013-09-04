<?php

namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * liste des taxes connus, et de leurs application
 * Le rang 0 est applicable mais non cummulable,
 * Tous ce qui a un rang non null est composé ex: TPS: rang 1, TVQ rang 2 , on peut pense à un spécial pour 0, le rang sinon commence à 1
 * @ORM\Table()
 * @ORM\Entity()
 */
class Tax {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ORM\ManyToOne(targetEntity="Haven\Bundle\PersonaBundle\Entity\State", inversedBy="translations")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $state;


    /**
     * @ORM\Column(name="name", type="string", length=8)
     */
    protected $name;

    /**
     * @ORM\Column(name="rate", type="float", nullable=false)
     */
    protected $rate;

    /**
     * le rang servira lorsque le rate est composé, il sert à dire à quel rang la taxe sera calcule, ex Québec TPS rang 0 (calculé seule) puis TVQ rang 1 (calculé avec le total de base + rangs précédent)
     * @ORM\Column(name="rang", type="integer", nullable=true)
     */
    protected $rang;



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
     * @return Tax
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
     * Set rate
     *
     * @param float $rate
     * @return Tax
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     * @return Tax
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set state
     *
     * @param Haven\Bundle\PersonaBundle\Entity\State $state
     * @return Tax
     */
    public function setState(\Haven\Bundle\PersonaBundle\Entity\State $state = null)
    {
        $this->state = $state;
    
        return $this;
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
}