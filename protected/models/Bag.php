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
    private $steps = array(
        'step1' => false,
        'step2' => false,
        'step3' => false,
    );

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
                $db = CTSQLite::connect();
                $query = 'SELECT quantity FROM ic_attribute WHERE id=' . $attID;
                $results = $db->query($query);
                $row = $results->fetchArray();
                //If quantity in order > quantity in store -> show message and add into bag quantity in store
                if ($item['quantity'] <= $row['quantity']) {
                    $this->items[$key]['quantity'] += 1;
                    $attIDExist = true;
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
            echo '[SECURITY]  Your bag is already empty';
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
                echo "that product doesn't exist";
                return false;
            }
        }
    }

    public function removeAtt($attID) {
        if (empty($this->items)) {
            echo '[SECURITY] Your bag is already empty';
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
                echo "Attribute group doesn't exist";
                return false;
            }
        }
    }

    public function getItemGroups() {
        $bagItems = $this->items;
        $productIDs = array();
        $itemGroups = array();
        foreach ($bagItems as $bagItem) {
            $productID = $bagItem['productID'];
            if (!\in_array($productID, $productIDs)) {
                array_push($productIDs, $productID);
                $pAtt = $bagItem['attribute'];
                $itemGroups[$productID] = array(
                    $pAtt['id'] => array(
                        "size" => $pAtt["size"],
                        "color" => $pAtt["color"],
                        "quantity" => $bagItem["quantity"],
                    )
                );
            } else {
                $pAtt = $bagItem['attribute'];
                $itemGroups[$productID][$pAtt['id']] = array(
                    "size" => $pAtt["size"],
                    "color" => $pAtt["color"],
                    "quantity" => $bagItem["quantity"],
                );
            }

            if (!empty($pAtt['id'])) {
                $db = CTSQLite::connect();
                $query = 'SELECT quantity FROM ic_attribute WHERE id=' . $pAtt['id'];
                $results = $db->query($query);
                $row = $results->fetchArray();
                //If quantity in order > quantity in store -> show message and add into bag quantity in store
                if ($bagItem['quantity'] > $row['quantity']) {
                    $GetNameProQuery = 'SELECT product_name FROM ic_product WHERE id=' . $productID;
                    $res = $db->query($GetNameProQuery);
                    $row_pro = $res->fetchArray();
                    echo "Your order: Product " . $row_pro['product_name'] . " , size "
                    . $itemGroups[$productID][$pAtt['id']]['size'] . " , color " . $itemGroups[$productID][$pAtt['id']]['color']
                    . " is OUT OF STOCK ! </br>";
                    $itemGroups[$productID][$pAtt['id']]['quantity'] = $row['quantity'];
                }
            }
        }
        return $itemGroups;
    }

    public function countItems() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }

    public function totalCal() {
        $total = 0;
        foreach ($this->items as $item) {
            $product = new Product($item['productID']);
            $price = $product->getVal('price');
            $sale = $product->getVal('sale');
            $total += $item['quantity'] * ($price - $price * $sale / 100);
        }
        return $total;
    }

}
