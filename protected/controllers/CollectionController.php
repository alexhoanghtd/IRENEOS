<?php

/**
 * Controller that control collections in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CollectionController extends CTController {

    public function actionIndex($param = 0) {
        CT::widgets('MainMenu')->setActive('collections');
        $this->render('index','data');
    }

    public function actionView($param) {
        //example datam 
        $data = array(
            "id" => $param,
            "name" => "NEW ARRIVALS",
            "description" => "Lorem ispilitum salenacopet topcare monitor lief",
        );
        CT::widgets('MainMenu')->setActive('collections');
        $this->render('view',$data);
        //echo 'aready render the data';
    }

}
