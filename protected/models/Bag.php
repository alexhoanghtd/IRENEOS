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

    public function add($bagItem) {
        $itemAttribute = $bagItem['attribute'];
        $itemIDs = array_keys($this->items);
        $itemExisted = false;
        foreach($itemIDs as $itemID){
            $itemOldAtt = $this->items[$itemID]['attribute'];
            if($itemOldAtt['id'] ==  $itemAttribute['id']){
                $itemExisted = true;
                $currQuan = (int)$this->items[$itemID]['quantity'];
                $currQuan += (int)$bagItem['quantity'];
                $this->items[$itemID]['quantity'] = $currQuan;
            }
        }
        if(!$itemExisted){
            array_push($this->items,$bagItem);
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
}
