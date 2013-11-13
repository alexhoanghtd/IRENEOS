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
            CT_ADMIN => "*",//Which action Admin can acess
            CT_VISITOR => "*",//Which action visitor can access
            CT_USER => "*", //Which action authorized user can acess
            "allow" => array(CT_ADMIN,CT_USER,CT_VISITOR) //who can access the controller
        );
    }

    public function actionIndex($param = 0) {
        // echo CT::user()->bag()->countItems();
        $val = "never";
        echo "I $val use this before";
    }

    public function actionView($param) {
        $product = new Product();
        //print_r($product->fieldRules());
        print_r($product->getTableStruct());
        //$product->validate();
    }
    public function actionAjaxTest($pID){
        //echo $pID;
        $product = new Product($pID);
        print_r($product->getData());
        $this->render('ajaxTest', '');
    }
    public function actionSwitch(){
        echo 'your current role is '.CT::user()->getRole();
        CT::user()->setRole(CT_ADMIN);
        echo '<br>'.CT::user()->getRole();
    }
    public function actionDestroy(){
        session_unset();
        session_destroy();
    }

}
