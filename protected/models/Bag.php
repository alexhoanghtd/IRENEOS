<?php

/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Bag {

    private $items = array();

    public function __construct() {
        
    }

    public function getItemNumber() {
        return count($this->items);
    }

    public function add(BagItem $bagItem) {
        if($item = $this->isItemExisted($bagItem)){
            
        }else{
            array_push($items, $bagItem);
            return true;
        }
    }

    public function listAll() {
        print_r($this->items);
    }
    public function getItems(){
        return $this->items;
    }
    public function clearBag(){
        $this->items = null;
    }
    
    /**
     * Check if the item with a product ID already existed
     * @param type $productID
     * @return boolean
     */
    public function isItemExisted(BagItem $bagItem){
        if(empty($this->items)){
            return false;
        }else{
            foreach($this->items as $item){
                if($item->productID() ==  $bagItem->productID()){
                    return $item;
                    return true;
                }
            }
            return false;
        }
    }
}
