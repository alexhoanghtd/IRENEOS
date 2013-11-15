<?php

class AdminController extends CTController{
    /** return an array of rules that specify the acess level of user in the 
     * system
     * @return array
     */
    public function rules(){
        return array(
            CT_ADMIN => "*",
            CT_VISITOR => "*",
            CT_USER => "*",
            "allow" => array(CT_ADMIN), //who can access the controller
        );
    }
    public function __construct() {
        parent::__construct();
        CT::widgets('MainMenu')->setActive(ADMIN_MENU,'');
        
    }
    
    public function actionIndex(){
        $model = new Admin();
        $data = $model->countProductsUsers();
        $this->render('index', $data);
    }
    
    
}