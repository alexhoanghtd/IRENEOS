<?php

/**
 * Description of BagController
 *
 * @author Alex Hoang
 */
class BagController extends CTController {

    public function rules() {
        return array(
            CT_ADMIN => "*",
            CT_VISITOR => "*",
            CT_USER => "*",
            "allow" => "*", //who can access the controller
        );
    }

    //put your code here
    public function actionAdd() {
        //echo 'wut';
        if (isset($_POST) && !empty($_POST)) {
            //print_r($_POST);
            $productID = $_POST['id'];
            $attributes = $_POST['attribute'];
            $attIDs = array_keys($attributes);
            foreach ($attIDs as $attID) {
                $attBagQuantity = (int) $attributes[$attID]['quantity'];
                if ($attBagQuantity > 0) {
                    $bagItem = array(
                        "productID" => $productID,
                        "attribute" => array(
                            "id" => $attID,
                            "size" => $_POST[$attID]['size'],
                            "color" => $_POST[$attID]['color'],
                        ),
                        "quantity" => $attBagQuantity,
                    );
                    CT::user()->addToBag($bagItem);
                }
            }
        }
        header("Location: http://irene.local/bag/View");
    }

    public function actionView() {
        $itemGroups = CT::user()->bag()->getItemGroups();
        CT::widgets('MainMenu')->setActive(USER_MENU, 'bags');
        $this->render('view', $itemGroups);
    }

    public function actionAddUp($attID) {
        CT::user()->bagAddUp($attID);
        header("Location: http://irene.local/bag/View");
    }

    public function actionSubDown($attID) {
        echo 'you want to sub down';
        CT::user()->bagSubDown($attID);
        header("Location: http://irene.local/bag/View");
    }

    public function actionRemoveAtt($attID) {
        CT::user()->removeAtt($attID);
        header("Location: http://irene.local/bag/View");
    }

    public function actionRemove($productID) {
        CT::user()->remove($productID);
        header("Location: http://irene.local/bag/View");
    }

    public function actionCheckout() {
        if (CT::user()->bag()->countItems() > 0) {
            if (isset($_POST['shipping'])) {
                Bill::placeOrder($_POST['shipping']);
            }
            $this->render('checkout', '');
        } else {
            CT::redirect_to("/Category/");
        }
    }

}
