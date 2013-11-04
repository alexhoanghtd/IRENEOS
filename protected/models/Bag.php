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
        if ($this->isItemExisted($bagItem)) {
            $attID = $bagItem['attribute']['id'];
            $attQuan = (int) $bagItem['quantity'];
            $keys = array_keys($this->items);
            foreach ($keys as $key) {
                $currQuan = (int) $this->items[$key]['quantity'];
                $currAttID = $this->items[$key]['attribute']['id'];
                if ($currAttID == $attID) {
                    $currQuan += $attQuan;
                    $this->items[$key]['quantity'] = $currQuan;
                }
            }
        } else {
            array_push($this->items, $bagItem);
        }
    }

    public function listAll() {
        print_r($this->items);
    }

    public function getItems() {
        return $this->items;
    }

    public function clearBag() {
        $this->items = null;
    }

    /**
     * Check if the item with a product ID already existed
     * @param type $productID
     * @return boolean
     */
    public function isItemExisted($bagItem) {
        if (empty($this->items)) {
            return false;
        } else {
            foreach ($this->items as $item) {
                if ($item['attribute']['id'] == $bagItem['attribute']['id']) {
                    return true;
                }
            }
            return false;
        }
    }

    /*
     * add one unit of item to the attribute
     * 
     */

    public function bagAddUp($attID) {
        if (empty($this->items)) {
            echo '[SECURITY]You are trying to add nonexited attID';
            return false;
        }
        $attIDExist = false;
        foreach ($this->items as $key => $item) {
            if ($item['attribute']['id'] == $attID) {
                $this->items[$key]['quantity'] += 1;
                $attIDExist = true;
            }
        }
        if ($attIDExist) {
            return true;
        } else {
            echo '[SECURITY]The ID you trying to put is not exist';
            return false;
        }
    }

    /*
     * add one unit of item to the attribute
     * 
     */

    public function bagSubDown($attID) {
        if (empty($this->items)) {
            echo '[SECURITY]You are trying to sub nonexited attID';
            return false;
        }
        $attIDExist = false;
        foreach ($this->items as $key => $item) {
            if ($item['attribute']['id'] == $attID) {
                $attIDExist = true;
                if ($item['quantity'] > 1) {
                    $this->items[$key]['quantity'] = (int) $item['quantity'] - 1;
                } else {
                    unset($this->items[$key]);
                }
            }
        }
        if ($attIDExist) {
            return true;
        } else {
            echo '[SECURITY]The ID you trying to put is not exist';
            return false;
        }
    }

    public function removeItem($productID) {
        if (empty($this->items)) {
            echo '[SECURITY] I am tired of what you are trying to do';
            return false;
        } else {
            $productIDExist = false;
            foreach ($this->items as $key => $item) {
                if ($item['productID'] == $productID) {
                    $productIDExist = true;
                    unset($this->items[$key]);
                }
            }
            if ($productIDExist) {
                return true;
            } else {
                echo 'IAM TIRED!!!!';
                return false;
            }
        }
    }

    public function removeAtt($attID) {
        if (empty($this->items)) {
            echo '[SECURITY] I am tired of what you are trying to do';
            return false;
        } else {
            $attIDExist = false;
            foreach ($this->items as $key => $item) {
                if ($item['attribute']['id'] == $attID) {
                    unset($this->items[$key]);
                }
            }
            if ($attIDExist) {
                return true;
            } else {
                echo 'IAM TIRED!!!!';
                return false;
            }
        }
    }

}
