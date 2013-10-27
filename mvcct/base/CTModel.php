<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CTModel {

    public $db;
    function actionIndex() {
        echo 'base model class loaded';
    }
    
    public function __construct() {
        $this->db = $this->connect();
    }
    protected function connect() {
        $dbInfo = CT::$_CONFIG['db'];
        $connectionString = $dbInfo['connectionString'];
        return $db = new SQLite3(BASE_PATH.$connectionString);
        
        $results = $db->query('SELECT * FROM ic_product');
//        $results->numColumns();
//        while ($row = $results->fetchArray()) {
//            var_dump($row);
//        }
    }
    public function update($id,$data){
        
    }
    public function delete($id){
        
    }
    public function getData($id){
        
    }
    public function create($data){
        
    }

}
