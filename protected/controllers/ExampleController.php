<?php

/**
 * examle controller to manage an example controller
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */
class ExampleController extends CTController {

    public function actionIndex($param = 0) {
        $model = new Product();
        echo $model->hasCol('name') ? 'exited' : 'not exited<br/>';
        $arr = array(
            'something' => 'smt',
            'someEmpty' => "ks;g,mniei<eslk b/sklsi dcon gà trống nó đi ăn đêmownde //n",
            'array' => array(
              'araaaaay' => '', 
            ),
            'bool' => true,
            'aFloat' => 9.3,
            'aint' => 1,
            'and null' => null,
        );
        if(isset($arr['notexisted'])){
            echo 'seted <br/>';
        }else{
            echo 'is not set <br/>';
        }
        foreach (array_keys($arr) as $val){
            echo gettype($arr[$val]).' | ';
            echo $val."<br/>";
        }
        
        echo ('INTEGER' == 'integer') ? 'yes' : 'no';
        
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
