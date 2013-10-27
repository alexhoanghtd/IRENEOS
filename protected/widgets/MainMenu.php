<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MainMenu{
    private $items;
    private $active;
    private $view;
    private $viewBluePrint;
    public function __construct() {
        $this->items = CT::$_CONFIG['widgets']['MainMenu'];
        $this->viewBluePrint = 'mainMenu';
        $this->active = 'new arrivals';
    }
    private function renderMenu(){
        ob_start();
        $viewFile = BASE_PATH.'/protected/widgets/views/'.$this->viewBluePrint.'.php';
        include($viewFile);
        $returned = ob_get_contents();
        ob_end_clean();
        return $returned;
    }
    public function setActive($active){
        $this->active = $active;
    }
    public function show(){
        echo $this->renderMenu();
    }
}