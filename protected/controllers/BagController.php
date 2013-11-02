<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BagController
 *
 * @author Alex Hoang
 */
class BagController extends CTController {

    //put your code here
    public function actionAdd() {
        if (isset($_POST)) {
            $productID = $_POST['id'];
            echo "you about to add productID=".$productID."<br/>";
            $attributes = $_POST['attribute'];
            $attIDs = array_keys($attributes);
            foreach ($attIDs as $attID) {
                $attQuantity = (int)$attributes[$attID]['quantity'];
                if ( $attQuantity > 0){
                    echo "Attributeid=".$attID." and ".$attQuantity. " item(s) <br/>";
                }
            }
        }
    }

}
