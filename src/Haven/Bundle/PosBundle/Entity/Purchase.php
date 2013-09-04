<?php

namespace Haven\Bundle\PosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Table(name="Purchase")
 * @ORM\Entity()
 */
class Purchase  implements \Serializable 
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

//    /**
//     * @ORM\ManyToOne(targetEntity="Haven\Bundle\PersonaBundle\Entity\Contact")
//     */
//    protected $utilisateur;

    /**
     * @ORM\Column(name="created_at", type="date")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="updated_at", type="date")
     */
    protected $updated_at;

    /**
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @ORM\Column(name="memo", type="string", length=256, nullable=true, nullable = true)
     */
    protected $memo;

    /**
     * concatenate name and firstname for people, or just group name
     * @ORM\Column(name="delivery_name", type="string", length=256, nullable = true)
     */
    protected $delivery_name;

    /**
     * @ORM\Column(name="delivery_address1", type="string", length=256, nullable = true)
     */
    protected $delivery_address1;

    /**
     * @ORM\Column(name="delivery_address2", type="string", length=256, nullable = true)
     */
    protected $delivery_address2;

    /**
     * @ORM\Column(name="delivery_telephone", type="string", length=24, nullable = true )
     */
    protected $delivery_telephone;

    /**
     * @ORM\Column(name="delivery_city", type="string", length=64, nullable = true)
     */
    protected $delivery_city;

    /**
     * @ORM\Column(name="delivery_postal_code", type="string", length=16, nullable = true)
     */
    protected $delivery_postal_code;

    /**
     * @ORM\Column(name="delivery_state", type="string", length=24, nullable = true)
     */
    protected $delivery_state;

    /**
     * @ORM\Column(name="delivery_country", type="string", length=24, nullable = true)
     */
    protected $delivery_country;

    /**
     * concatenate name and firstname for people, or just group name
     * @ORM\Column(name="invoicing_name", type="string", length=256, nullable = true)
     */
    protected $invoicing_name;

    /**
     * @ORM\Column(name="invoicing_address1", type="string", length=256, nullable = true)
     */
    protected $invoicing_address1;

    /**
     * @ORM\Column(name="invoicing_address2", type="string", length=256, nullable = true)
     */
    protected $invoicing_address2;

    /**
     * @ORM\Column(name="invoicing_telephone", type="string", length=24, nullable = true)
     */
    protected $invoicing_telephone;

    /**
     * @ORM\Column(name="invoicing_city", type="string", length=64, nullable = true)
     */
    protected $invoicing_city;

    /**
     * @ORM\Column(name="invoicing_postal_code", type="string", length=16, nullable = true)
     */
    protected $invoicing_postal_code;

    /**
     * @ORM\Column(name="invoicing_state", type="string", length=24, nullable = true)
     */
    protected $invoicing_state;

    /**
     * @ORM\Column(name="invoicing_country", type="string", length=24, nullable = true)
     */
    protected $invoicing_country;

    /**
     * le total sans les tax ni le shipping
     * @ORM\Column(name="purchase_total_raw", type="decimal", scale=2, nullable = true)
     */
    protected $purchase_total_raw;

    /**
     * le montant total des tax
     * @ORM\Column(name="purchase_tax", type="decimal", scale=2, nullable = true)
     */
    protected $purchase_total_tax;

    /**
     * le total charger avec les tax et la delivery
     * @ORM\Column(name="purchase_total_charges", type="decimal", scale=2, nullable = true)
     */
    protected $purchase_total_charges;

    /**
     * @ORM\Column(name="delivery_charge", type="decimal", scale=2 , nullable = true)
     */
    protected $delivery_charge;

    /**
     * Le code international de 3 lettre pour la currency
     * @ORM\Column(name="currency", type="string", length=3, nullable = true)
     */
    protected $purchase_currency;

    /**
     * ici mettre une tables de tax pour la purchase lien a table tax pour savoir lesquelle s'appliques, il faut aussi des règles d'application
     * ce n'est pas ici le calcul des tax juste la liste de tax (ex: TPS, TVQ et leurs valeurs, donc ManyToManyWithExtraField , l'extra field à la valeur du moment pour la taxe
     * @ORM\OneToMany(targetEntity="PurchaseTax", mappedBy="purchase", cascade={"persist"})
     */
    protected $purchase_tax_applicables;

    /**
     *
     * @ORM\OneToMany(targetEntity="PurchaseProduct", mappedBy="purchase", cascade={"all"})
     */
    protected $purchase_products;

    /**
     * @ORM\Column(name="confirmation", type="text", nullable=true)
     */
    protected $confirmation;

    /**
     * Constructor
     */
    public function __construct() {
        $this->purchase_tax_applicables = new \Doctrine\Common\Collections\ArrayCollection();
        $this->purchase_products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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
     * @param \DateTime $createdAt
     * @return Purchase
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Purchase
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Purchase
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
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
     * Set memo
     *
     * @param string $memo
     * @return Purchase
     */
    public function setMemo($memo) {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     *
     * @return string 
     */
    public function getMemo() {
        return $this->memo;
    }

    /**
     * Set delivery_name
     *
     * @param string $deliveryName
     * @return Purchase
     */
    public function setDeliveryName($deliveryName) {
        $this->delivery_name = $deliveryName;

        return $this;
    }

    /**
     * Get delivery_name
     *
     * @return string 
     */
    public function getDeliveryName() {
        return $this->delivery_name;
    }

    /**
     * Set delivery_address1
     *
     * @param string $deliveryAddress1
     * @return Purchase
     */
    public function setDeliveryAddress1($deliveryAddress1) {
        $this->delivery_address1 = $deliveryAddress1;

        return $this;
    }

    /**
     * Get delivery_address1
     *
     * @return string 
     */
    public function getDeliveryAddress1() {
        return $this->delivery_address1;
    }

    /**
     * Set delivery_address2
     *
     * @param string $deliveryAddress2
     * @return Purchase
     */
    public function setDeliveryAddress2($deliveryAddress2) {
        $this->delivery_address2 = $deliveryAddress2;

        return $this;
    }

    /**
     * Get delivery_address2
     *
     * @return string 
     */
    public function getDeliveryAddress2() {
        return $this->delivery_address2;
    }

    /**
     * Set delivery_telephone
     *
     * @param string $deliveryTelephone
     * @return Purchase
     */
    public function setDeliveryTelephone($deliveryTelephone) {
        $this->delivery_telephone = $deliveryTelephone;

        return $this;
    }

    /**
     * Get delivery_telephone
     *
     * @return string 
     */
    public function getDeliveryTelephone() {
        return $this->delivery_telephone;
    }

    /**
     * Set delivery_city
     *
     * @param string $deliveryCity
     * @return Purchase
     */
    public function setDeliveryCity($deliveryCity) {
        $this->delivery_city = $deliveryCity;

        return $this;
    }

    /**
     * Get delivery_city
     *
     * @return string 
     */
    public function getDeliveryCity() {
        return $this->delivery_city;
    }

    /**
     * Set delivery_postal_code
     *
     * @param string $deliveryPostalCode
     * @return Purchase
     */
    public function setDeliveryPostalCode($deliveryPostalCode) {
        $this->delivery_postal_code = $deliveryPostalCode;

        return $this;
    }

    /**
     * Get delivery_postal_code
     *
     * @return string 
     */
    public function getDeliveryPostalCode() {
        return $this->delivery_postal_code;
    }

    /**
     * Set delivery_state
     *
     * @param string $deliveryState
     * @return Purchase
     */
    public function setDeliveryState($deliveryState) {
        $this->delivery_state = $deliveryState;

        return $this;
    }

    /**
     * Get delivery_state
     *
     * @return string 
     */
    public function getDeliveryState() {
        return $this->delivery_state;
    }

    /**
     * Set delivery_country
     *
     * @param string $deliveryCountry
     * @return Purchase
     */
    public function setDeliveryCountry($deliveryCountry) {
        $this->delivery_country = $deliveryCountry;

        return $this;
    }

    /**
     * Get delivery_country
     *
     * @return string 
     */
    public function getDeliveryCountry() {
        return $this->delivery_country;
    }

    /**
     * Set invoicing_name
     *
     * @param string $invoicingName
     * @return Purchase
     */
    public function setInvoicingName($invoicingName) {
        $this->invoicing_name = $invoicingName;

        return $this;
    }

    /**
     * Get invoicing_name
     *
     * @return string 
     */
    public function getInvoicingName() {
        return $this->invoicing_name;
    }

    /**
     * Set invoicing_address1
     *
     * @param string $invoicingAddress1
     * @return Purchase
     */
    public function setInvoicingAddress1($invoicingAddress1) {
        $this->invoicing_address1 = $invoicingAddress1;

        return $this;
    }

    /**
     * Get invoicing_address1
     *
     * @return string 
     */
    public function getInvoicingAddress1() {
        return $this->invoicing_address1;
    }

    /**
     * Set invoicing_address2
     *
     * @param string $invoicingAddress2
     * @return Purchase
     */
    public function setInvoicingAddress2($invoicingAddress2) {
        $this->invoicing_address2 = $invoicingAddress2;

        return $this;
    }

    /**
     * Get invoicing_address2
     *
     * @return string 
     */
    public function getInvoicingAddress2() {
        return $this->invoicing_address2;
    }

    /**
     * Set invoicing_telephone
     *
     * @param string $invoicingTelephone
     * @return Purchase
     */
    public function setInvoicingTelephone($invoicingTelephone) {
        $this->invoicing_telephone = $invoicingTelephone;

        return $this;
    }

    /**
     * Get invoicing_telephone
     *
     * @return string 
     */
    public function getInvoicingTelephone() {
        return $this->invoicing_telephone;
    }

    /**
     * Set invoicing_city
     *
     * @param string $invoicingCity
     * @return Purchase
     */
    public function setInvoicingCity($invoicingCity) {
        $this->invoicing_city = $invoicingCity;

        return $this;
    }

    /**
     * Get invoicing_city
     *
     * @return string 
     */
    public function getInvoicingCity() {
        return $this->invoicing_city;
    }

    /**
     * Set invoicing_postal_code
     *
     * @param string $invoicingPostalCode
     * @return Purchase
     */
    public function setInvoicingPostalCode($invoicingPostalCode) {
        $this->invoicing_postal_code = $invoicingPostalCode;

        return $this;
    }

    /**
     * Get invoicing_postal_code
     *
     * @return string 
     */
    public function getInvoicingPostalCode() {
        return $this->invoicing_postal_code;
    }

    /**
     * Set invoicing_state
     *
     * @param string $invoicingState
     * @return Purchase
     */
    public function setInvoicingState($invoicingState) {
        $this->invoicing_state = $invoicingState;

        return $this;
    }

    /**
     * Get invoicing_state
     *
     * @return string 
     */
    public function getInvoicingState() {
        return $this->invoicing_state;
    }

    /**
     * Set invoicing_country
     *
     * @param string $invoicingCountry
     * @return Purchase
     */
    public function setInvoicingCountry($invoicingCountry) {
        $this->invoicing_country = $invoicingCountry;

        return $this;
    }

    /**
     * Get invoicing_country
     *
     * @return string 
     */
    public function getInvoicingCountry() {
        return $this->invoicing_country;
    }

    /**
     * Set purchase_total_raw
     *
     * @param float $purchaseTotalRaw
     * @return Purchase
     */
    public function setPurchaseTotalRaw($purchaseTotalRaw) {
        $this->purchase_total_raw = $purchaseTotalRaw;

        return $this;
    }

    /**
     * Get purchase_total_raw
     *
     * @return float 
     */
    public function getPurchaseTotalRaw() {
        return $this->purchase_total_raw;
    }

    /**
     * Set purchase_total_tax
     *
     * @param float $purchaseTotalTax
     * @return Purchase
     */
    public function setPurchaseTotalTax($purchaseTotalTax) {
        $this->purchase_total_tax = $purchaseTotalTax;

        return $this;
    }

    /**
     * Get purchase_total_tax
     *
     * @return float 
     */
    public function getPurchaseTotalTax() {
        return $this->purchase_total_tax;
    }

    /**
     * Set purchase_total_charges
     *
     * @param float $purchaseTotalCharges
     * @return Purchase
     */
    public function setPurchaseTotalCharges($purchaseTotalCharges) {
        $this->purchase_total_charges = $purchaseTotalCharges;

        return $this;
    }

    /**
     * Get purchase_total_charges
     *
     * @return float 
     */
    public function getPurchaseTotalCharges() {
        return $this->purchase_total_charges;
    }

    /**
     * Set delivery_charge
     *
     * @param float $deliveryCharge
     * @return Purchase
     */
    public function setDeliveryCharge($deliveryCharge) {
        $this->delivery_charge = $deliveryCharge;

        return $this;
    }

    /**
     * Get delivery_charge
     *
     * @return float 
     */
    public function getDeliveryCharge() {
        return $this->delivery_charge;
    }

    /**
     * Set purchase_currency
     *
     * @param string $purchaseCurrency
     * @return Purchase
     */
    public function setPurchaseCurrency($purchaseCurrency) {
        $this->purchase_currency = $purchaseCurrency;

        return $this;
    }

    /**
     * Get purchase_currency
     *
     * @return string 
     */
    public function getPurchaseCurrency() {
        return $this->purchase_currency;
    }

    /**
     * Set confirmation
     *
     * @param string $confirmation
     * @return Purchase
     */
    public function setConfirmation($confirmation) {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return string 
     */
    public function getConfirmation() {
        return $this->confirmation;
    }

    /**
     * Add purchase_tax_applicables
     *
     * @param Haven\Bundle\PosBundle\Entity\PurchaseTax $purchaseTaxApplicables
     * @return Purchase
     */
    public function addPurchaseTaxApplicable(\Haven\Bundle\PosBundle\Entity\PurchaseTax $purchaseTaxApplicables) {
        $this->purchase_tax_applicables[] = $purchaseTaxApplicables;

        return $this;
    }

    /**
     * Remove purchase_tax_applicables
     *
     * @param Haven\Bundle\PosBundle\Entity\PurchaseTax $purchaseTaxApplicables
     */
    public function removePurchaseTaxApplicable(\Haven\Bundle\PosBundle\Entity\PurchaseTax $purchaseTaxApplicables) {
        $this->purchase_tax_applicables->removeElement($purchaseTaxApplicables);
    }

    /**
     * Get purchase_tax_applicables
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPurchaseTaxApplicables() {
        return $this->purchase_tax_applicables;
    }

    /**
     * Add purchase_products
     *
     * @param Haven\Bundle\PosBundle\Entity\PurchaseProduct $purchaseProducts
     * @return Purchase
     */
    public function addPurchaseProduct(\Haven\Bundle\PosBundle\Entity\PurchaseProduct $purchaseProducts) {
        $this->purchase_products[] = $purchaseProducts;

        return $this;
    }
    
    public function setPurchaseProducts( $purchaseProducts) {
        $this->purchase_products = $purchaseProducts;

        return $this;
    }

    /**
     * Remove purchase_products
     *
     * @param Haven\Bundle\PosBundle\Entity\PurchaseProduct $purchaseProducts
     */
    public function removePurchaseProduct(\Haven\Bundle\PosBundle\Entity\PurchaseProduct $purchaseProducts) {
        $this->purchase_products->removeElement($purchaseProducts);
    }

    /**
     * Get purchase_products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPurchaseProducts() {
        return $this->purchase_products;
    }

    public function serialize() {
        $data["id"] = $this->id;
        $data["memo"] = $this->memo;


        $data["delivery_address1"] = $this->delivery_address1;
        $data["delivery_address2"] = $this->delivery_address2;
        $data["delivery_city"] = $this->delivery_city;
        $data["delivery_country"] = $this->delivery_country;
        $data["delivery_name"] = $this->delivery_name;
        $data["delivery_postal_code"] = $this->delivery_postal_code;
        $data["delivery_state"] = $this->delivery_state;
        $data["delivery_telephone"] = $this->delivery_telephone;

        $data["invoicing_address1"] = $this->invoicing_address1;
        $data["invoicing_address2"] = $this->invoicing_address2;
        $data["invoicing_city"] = $this->invoicing_city;
        $data["invoicing_country"] = $this->invoicing_country;
        $data["invoicing_name"] = $this->invoicing_name;
        $data["invoicing_postal_code"] = $this->invoicing_postal_code;
        $data["invoicing_state"] = $this->invoicing_state;
        $data["invoicing_telephone"] = $this->invoicing_telephone;

        $data["purchase_products"] = serialize($this->getPurchaseProducts());
        
        $data["purchase_currency"] = $this->purchase_currency;
        $data["purchase_tax_applicables"] = $this->purchase_tax_applicables;
        $data["purchase_total_charges"] = $this->purchase_total_charges;
        $data["purchase_total_raw"] = $this->purchase_total_raw;
        $data["purchase_total_tax"] = $this->purchase_total_tax;

        $data["delivery_charge"] = $this->delivery_charge;

        $data["status"] = $this->status;
        $data["confirmation"] = $this->confirmation;

        $data["updated_at"] = $this->updated_at;
        $data["created_at"] = $this->created_at;
        return serialize($data);
    }

    public function unserialize($data) {
        $data = unserialize($data);
        $this->id = $data["id"];
        $this->memo = $data["memo"];


        $this->delivery_address1 = $data["delivery_address1"];
        $this->delivery_address2 = $data["delivery_address2"];
        $this->delivery_city = $data["delivery_city"];
        $this->delivery_country = $data["delivery_country"];
        $this->delivery_name = $data["delivery_name"];
        $this->delivery_postal_code = $data["delivery_postal_code"];
        $this->delivery_state = $data["delivery_state"];
        $this->delivery_telephone = $data["delivery_telephone"];

        $this->invoicing_address1 = $data["invoicing_address1"];
        $this->invoicing_address2 = $data["invoicing_address2"];
        $this->invoicing_city = $data["invoicing_city"];
        $this->invoicing_country = $data["invoicing_country"];
        $this->invoicing_name = $data["invoicing_name"];
        $this->invoicing_postal_code = $data["invoicing_postal_code"];
        $this->invoicing_state = $data["invoicing_state"];
        $this->invoicing_telephone = $data["invoicing_telephone"];

        $this->setPurchaseProducts(unserialize($data["purchase_products"]));
        
        $this->purchase_currency = $data["purchase_currency"];
        $this->purchase_tax_applicables = $data["purchase_tax_applicables"];
        $this->purchase_total_charges = $data["purchase_total_charges"];
        $this->purchase_total_raw = $data["purchase_total_raw"];
        $this->purchase_total_tax = $data["purchase_total_tax"];

        $this->delivery_charge = $data["delivery_charge"];

        $this->status = $data["status"];
        $this->confirmation = $data["confirmation"];

        $this->updated_at = $data["updated_at"];
        $this->created_at = $data["created_at"];
    }

}