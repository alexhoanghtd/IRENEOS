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
        //echo 'wut';
        if (isset($_POST) && !empty($_POST)) {
            //print_r($_POST);
            $productID = $_POST['id'];
            $attributes = $_POST['attribute'];
            $attIDs = array_keys($attributes);
            foreach ($attIDs as $attID) {
                $attQuantity = (int) $attributes[$attID]['quantity'];
                if ($attQuantity > 0) {
                    $bagItem = array(
                        "productID" => $productID,
                        "attribute" => array(
                            "id" => $attID,
                            "size" => $_POST[$attID]['size'],
                            "color" => $_POST[$attID]['color'],
                        ),
                        "quantity" => $attQuantity,
                    );
                    CT::user()->addToBag($bagItem);
                }
            }
        }
        header("Location: http://irene.local/bag/View");
    }

    public function actionView() {
        $bagItems = CT::user()->bag()->getItems();
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
        }
        CT::widgets('MainMenu')->setActive(USER_MENU,'bags');
        $this->render('view', $itemGroups);
    }
    
    public function actionAddUp($attID){
        CT::user()->bagAddUp($attID);
        header("Location: http://irene.local/bag/View");
    }
    
    public function actionSubDown($attID){
        echo 'you want to sub down';
        CT::user()->bagSubDown($attID);
        header("Location: http://irene.local/bag/View");
    }
    
    public function actionRemoveAtt($attID){
        CT::user()->removeAtt($attID);
        header("Location: http://irene.local/bag/View");
    }
    
    public function actionRemove($productID){
        CT::user()->remove($productID);
        header("Location: http://irene.local/bag/View");
    }
    
}
