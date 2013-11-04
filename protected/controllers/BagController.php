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
        if (isset($_POST) && !empty($_POST)) {
            $productID = $_POST['id'];
            $attributes = $_POST['attribute'];
            $attIDs = array_keys($attributes);
            foreach ($attIDs as $attID) {
                $attQuantity = (int)$attributes[$attID]['quantity'];
                if ( $attQuantity > 0){
                    $bagItem = array(
                        "productID" => $productID,
                        "attribute" => array(
                            "id" => $attID,
                            "size" => $attributes[$attID]['size'],
                            "color" => $attributes[$attID]['color'],
                        ), 
                        "quantity" => $attQuantity,
                    );
                    CT::user()->addToBag($bagItem);
                }
            }
        }
        CT::user()->bag()->listAll();
    }
    
    public function actionView(){
        $bagItem = CT::user()->bag()->getItems();
        $this->render('view', $bagItem);
    }

}
