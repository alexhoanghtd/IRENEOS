<?php

/**
 * examle controller to manage an example controller
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */
class ExampleController extends CTController {

    public function rules() {
        return array(
            CT_ADMIN => "*", //Which action Admin can acess
            CT_VISITOR => "Index", //Which action visitor can access
            CT_USER => "*", //Which action authorized user can acess
            "allow" => array(CT_ADMIN, CT_USER, CT_VISITOR) //who can access the controller
        );
    }

    public function actionIndex($param = 0) {
<<<<<<< HEAD
        echo CT::user()->getRole();
        // CT::user()->resetDatas();
        print_r(CT::user()->getDatas());
=======

        // echo CT::user()->bag()->countItems();
        echo CT::user()->bag()->totalCal();

        echo CT::user()->getRole();
        $val = "never";
        echo "I $val use this before";
>>>>>>> 08d9ee5fca0b0e93df941ee08f9fd46789662544
    }

    public function actionView($param) {
        $product = new Product();
        //print_r($product->fieldRules());
        print_r($product->getTableStruct());
        //$product->validate();
    }

    public function actionAjaxTest($pID) {
        //echo $pID;
        $product = new Product($pID);
        print_r($product->getData());
        $this->render('ajaxTest', '');
    }

    public function actionSwitch() {
        echo 'your current role is ' . CT::user()->getRole();
        CT::user()->setRole(CT_ADMIN);
        echo '<br>' . CT::user()->getRole();
    }

    public function actionDestroy() {
        session_unset();
        session_destroy();
    }

}
