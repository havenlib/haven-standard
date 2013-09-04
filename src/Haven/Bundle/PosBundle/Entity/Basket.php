<?php

namespace Haven\Bundle\PosBundle\Entity;

class Basket {

    private $line_items;
    private $devise;

    public function getLineItems() {
        
        return $this->line_items;
    }

    public function addLineItem(LineItem $line_item) {
        $this->line_items[] = $line_item;
        
        return $this;
    }

    public function removeLineItem(LineItem $line_item) {
        echo "<br>".\Doctrine\Common\Util\Debug::dump($line_item,1)."<br />";
//        $this->line_items->removeElement($line_item);
    }

    public function getTotal() {
    }

    public function getDevise(){

        return $this->devise;
    }
    
    public function setDevise($devise){
        $this->devise = $devise;
        
        return $this;
    }

}
