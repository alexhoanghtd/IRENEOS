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
            CT_VISITOR => "View,Index,Destroy,Switch",//Which action visitor can access
            CT_USER => "View,Index", //Which action authorized user can acess
            "allow" => array(CT_ADMIN,CT_USER,CT_VISITOR) //who can access the controller
        );
    }

    public function actionIndex($param = 0) {
        echo 'you are in index action of Example controller<br>';
        echo 'your role is'.CT::user()->getRole();
    }

    public function actionView($param) {
        //$user = new CTUserIdentity();
        echo '<br/> you are in Example controller View action ';
        $data = array(
            "id" => $param,
            "name" => "Nina Black",
            "description" => "Lorem ispilitum salenacopet topcare monitor lief",
        );
        //$this->render($data, 'view');
        //echo 'aready render the data';
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
