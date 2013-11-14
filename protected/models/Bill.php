<?php

/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Bill extends CTModel {

    public function fieldRules() {
        return array(
            "id" => array(
                "maxLength" => 20,
                "minLength" => 1,
                "name" => "Identitier",
                "unique" => true,
                "required" => true,
            ),
            "customer_first_name" => array(
                "maxLength" => 300,
                "minLength" => 1,
                "name" => "First name",
                "required" => true,
            ),
            "customer_last_name" => array(
                "maxLength" => 300,
                "minLength" => 1,
                "name" => "Last name",
                "required" => true,
            ),
            "customer_email" => array(
                "maxLength" => 1000,
                "minLength" => 5,
                "name" => "Email",
                "required" => true,
                "regEx" => "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/",
            ),
            "customer_phone" => array(
                "maxLength" => 20,
                "minLength" => 6,   
                "name" => "Phone number",
                "required" => false,
                ),
        );
    }

    public static function placeOrder($data) {

        $bill = new Bill();
        $bill->setData($data);
        //print_r($bill->getData());
        print_r(CT::user()->bag()->listALl());
        if ($bill->validateCreate()) {
            echo 'validate sucessfully, bitch!<br>';
            
        }
    }

}
