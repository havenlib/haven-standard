<?php
namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class PurchaseTax {
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="purchase_taxes_applicables")
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     */
    protected $purchase;
    
    /**
     * @ORM\Column(name="name", type="string", length=8)
     */
    protected $name;

     /**
      *
      * @ORM\Column(name="rate", type="float")
      */
     protected $rate;
     /**
      *
      * @ORM\Column(name="applied_on", type="decimal", scale=2)
      */
     protected $applied_on;
     /**
      *
      * @ORM\Column(name="applied_amount", type="decimal", scale=2)
      */
     protected $applied_amount;

    /**
     * le rank servira lorsque le rate est composé, il sert à dire à quel rank la taxe sera calcule, ex Québec TPS rank 0 (calculé seule) puis TVQ rank 1 (calculé avec le total de base + ranks précédent)
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    protected $rank;


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
     * @return PurchaseTax
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
     * @return PurchaseTax
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
     * Set applied_on
     *
     * @param float $appliedOn
     * @return PurchaseTax
     */
    public function setAppliedOn($appliedOn)
    {
        $this->applied_on = $appliedOn;
    
        return $this;
    }

    /**
     * Get applied_on
     *
     * @return float 
     */
    public function getAppliedOn()
    {
        return $this->applied_on;
    }

    /**
     * Set applied_amount
     *
     * @param float $appliedAmount
     * @return PurchaseTax
     */
    public function setAppliedAmount($appliedAmount)
    {
        $this->applied_amount = $appliedAmount;
    
        return $this;
    }

    /**
     * Get applied_amount
     *
     * @return float 
     */
    public function getAppliedAmount()
    {
        return $this->applied_amount;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return PurchaseTax
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set purchase
     *
     * @param Haven\Bundle\PosBundle\Entity\Purchase $purchase
     * @return PurchaseTax
     */
    public function setPurchase(\Haven\Bundle\PosBundle\Entity\Purchase $purchase = null)
    {
        $this->purchase = $purchase;
    
        return $this;
    }

    /**
     * Get purchase
     *
     * @return Haven\Bundle\PosBundle\Entity\Purchase 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
}