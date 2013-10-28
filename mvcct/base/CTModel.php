<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CTModel {

    /**
     * Hold database connection
     * @var SQLite  
     */
    public $db;

    /**
     * Hold the default table name of the controller
     * @var string 
     */
    public $tableName;

    /**
     * Hold the structure of the table;
     * @var array
     */
    protected $table = array(
        'default_col' => array(
            'dbName' => 'colname', // Name of colum in the database
            'name' => 'name', // name definition
            'type' => 'TEXT', // data type of the colum
            'length' => '3', // the length of the talbe
            'required' => '0', // is the colum value
        ),
    );

    /**
     * Contstructor does: 
     * +Connect to database
     * +set the public attribute $db as the connection to sql database
     */
    public function __construct() {
        $this->db = $this->connect();
        $table = $this->db->query("pragma table_info(ic_product);");
        while ($col = $table->fetchArray()) {
            $this->table[$col['name']] = array(
                'dbName' => $col['name'], // Name of colum in the database
                'name' => '', // name definition
                'type' => $col['type'], // data type of the colum
                'length' => '', // the length of the talbe
                'required' => $col['notnull'], // is the colum value
            );
            //echo $col['name'].'|'.$col['type'].'<br />';
        }
        // print_r($this->table);
    }

    /**
     * Start the connection to sqlite 3 and return the database connection
     * that help you to execute the query
     * @return sqlite3 database connection
     */
    protected function connect() {
        $dbInfo = CT::$_CONFIG['db'];
        $connectionString = $dbInfo['connectionString'];
        $this->db = new SQLite3(BASE_PATH . $connectionString);
        return $this->db;
    }

    public function update($id, $data) {
        
    }

    /**
     * Delete id of the item in default table
     * @param int $id id of the item you want to delete
     */
    public function delete($id) {
        
    }

    public function getData($id) {
        
    }

    public function create($data) {
        
    }
    /**
     * Load model with model name
     * @param String name of the model you want to load.
     */
    function loadModel($model){
       $path = BASE_PATH.'/protected/models/' . $model . '.php'; 
       if(file_exists($path)){
            require $path;
            return new $model();
        }else{
            Bootstrap::error('Can not load the model');
        }
    }

}
