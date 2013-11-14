<?php

class AdminController extends CTController{
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