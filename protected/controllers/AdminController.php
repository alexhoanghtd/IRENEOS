<?php

class AdminController extends CTController{
    public function __construct() {
        parent::__construct();
        CT::widgets('MainMenu')->setActive(ADMIN_MENU,'');
        
    }
    
    public function actionIndex(){
        $this->render('index', '');
    }
}