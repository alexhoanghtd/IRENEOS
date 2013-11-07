<?php

class CTlist{
    public $model;
    public $viewFile;
    
    public function __construct() {
        $this->viewFile = BASE_PATH . '/protected/widgets/views/ctlist.php';
    }
    
    public function setModel($model){
        $this->model = $model;
    }
    
    public function render(){
        ob_start();
        include($this->viewFile);
        $returned = ob_get_contents();
        ob_end_clean();
        return $returned;
    }
}