<?php

class CTController{
    function actionIndex(){
        echo 'this will be default index of the BASE Controller class';
    }
    
    function loadModel($model){
        $path = 'models/' . $model . '.php';
        if(file_exists($path)){
            require $path;
            $this->model = new $model();
        }else{
            Bootstrap::error();
        }
    }
    
    function render($viewFile,$data){
        extract($data);
        require 'views/' . $viewFile . '.php';
    }
    
}   