<?php

/**
 * Hold the information about 1 bag item :) 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 3 Nov 2013
 * @copyright &copy; 2013 Creative Team 
 */
class BagItem {

    private $product;
    private $attributes = array();

    public function __construct($product, $attribute) {
        if (!isset($attribute['id']) || !isset($attribute['quantity'])) {
            echo '[SECURITY]your input data is invalid';
        } else {
            $this->product = $product;
            array_push($this->attributes, $attribute);
        }
    }

    public function productID() {
        return $this->product->getVal('id');
    }

    public function getProduct() {
        return $this->product();
    }

    public function updateItem($attribute) {
        //if the data of the attribute already existed
        if ($this->attrIDExists($attribute['id'])) {
            //increase the quantity data in existed attribute by the input quan
            $currQuan = $this->attributes[$attribute['id']]['quantity'];
            $currQuan += (int) $attribute['quantity'];
            $this->attributes[$attribute['id']]['quantity'] = $currQuan;
        } else {
            array_push($attributes, $attribute);
        }
    }

    //caculate the final price for that bag item
    public function calculateSubTotal() {
        $quan = 0;
        //update the newest product information
        $product = new Product($this->product->getVal('id'));
        $price = (float) $product->getVal('price');
        $sale = (float) $product->getVal('sale');
        foreach ($this->attributes as $attr) {
            $quan += $this->attributes['quantity'];
        }
        return $quan;
    }

    //checked if an attribute ID exists
    public function attrIDExists($id) {
        if (empty($this->attributes)) {
            return false;
        }
        foreach ($this->attributes as $attr) {
            if ($attr['id'] == $id) {
                return true;
            }
        }
        return false;
    }

}
