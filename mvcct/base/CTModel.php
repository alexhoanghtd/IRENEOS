<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CTModel{

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
     * Hold the result of the data
     */
    public $row;
    
    /**
     * Hold the structure of the table;
     * @var array
     */
    protected $table = array();

    /**
     * Contstructor does: 
     * +Connect to database
     * +set the public attribute $db as the connection to sql database
     */
    public function __construct() {
        $this->db = $this->connect();
        $this->getTableStruct();
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
    
    /**
     * get all the basic structure of the table according to model name
     * set to $this->table
     */
    protected function getTableStruct(){
        //get the table name according to model name 
        $tableName = $this->getTableName();
        //querry table structure
        $table = $this->db->query("pragma table_info(".$tableName.")");
        //building the structure
        while ($col = $table->fetchArray()) {
            $this->table[$col['name']] = array(
                'colName' => $col['name'], // Name of colum in the database
                'name' => '', // name definition
                'type' => $col['type'], // data type of the colum
                'length' => '', // the length of the talbe
                'required' => $col['notnull'], // is the colum value
            );
            //echo $col['name'].'|'.$col['type'].'<br />';
        }
        print_r($this->table);
    }
    /**
     * get Cell info
     */
    private function getCells(){
        
    }
    public function getTableName(){
        //get table prefix from config file
        $prefix = CT::$_CONFIG['db']['tablePrefix'];
        $this->tableName = $tableName = $prefix.strtolower(get_class($this));  
        return $this->tableName;
    }
    
    
    public function update($id, $data) {
        
    }

    /**
     * Delete id of the item in default table
     * @param int $id id of the item you want to delete
     */
    public function delete($id) {
        
    }

    public function get($id) {
        $result = $this->db->query(
                'SELECT * FROM '
                .$this->tableName.
                ' WHERE id='.$id
                );
        if($product = $result->fetchArray()){    
            print_r($product);
            return $product;
        }
        else{
            echo "product with id = ".$id."doesn't exist";
            return false;
        }
    }

    public function create() {
        
    }
    /**
     * Load model with model name
     * @param String name of the model you want to load.
     */
    static function loadModel($model){
       $path = BASE_PATH.'/protected/models/' . $model . '.php'; 
       if(file_exists($path)){
            require $path;
            return new $model();
        }else{
            Bootstrap::error('Can not load the model');
        }
    }

}
