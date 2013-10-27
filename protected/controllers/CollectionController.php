<?php

/**
 * Controller that control collections in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CollectionController extends CTController {

    public function actionIndex($param = 0) {
        $this->render('data', 'index');
    }

    public function actionView($param) {
        //example datam 
        $data = array(
            "id" => $param,
            "name" => "NEW ARRIVALS",
            "description" => "Lorem ispilitum salenacopet topcare monitor lief",
        );
        $this->render($data, 'view');
        //echo 'aready render the data';
    }

}
