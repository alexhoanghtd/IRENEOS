<?php

/**
 * examle controller to manage an example controller
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */
class ExampleController extends CTController {

    public function actionIndex($param = 0) {
        $this->render('data', 'index');
    }

    public function actionView($param) {
        //example datam 
        $data = array(
            "id" => $param,
            "name" => "Nina Black",
            "description" => "Lorem ispilitum salenacopet topcare monitor lief",
        );
        $this->render($data, 'view');
        //echo 'aready render the data';
    }

}