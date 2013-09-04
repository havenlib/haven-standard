<?php

namespace Haven\Bundle\PosBundle\Entity;

class LineItem{

    private $product;
    private $quantity;

    public function getProduct() {
        
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
        
        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        
        return $this;
    }

    public function getSubTotal($format = null) {
        return empty($format)?$this->quantity*$this->product->getPrice():money_format($format, $this->quantity*$this->product->getPrice());
    }


}

?>
