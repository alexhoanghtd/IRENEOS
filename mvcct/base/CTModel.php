<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CTModel extends CTSQLite implements IDBRecord {

    /**
     * Hold database connection
     * @var SQLite  
     */
    protected $db;

    /**
     * Hold the default table name of the controller
     * @var string 
     */
    private $tableName = "";

    /**
     * Hold the result of the data
     */
    private $row = array();

    /**
     * Hold the structure of the table;
     * @var array
     */
    protected $table = array();

    /**
     * Contstructor does: 
     * +Connect to database
     * +set the public attribute $db as the connection to sql database
     * +analyze and store the table structure
     */
    public function __construct($id = 0) {
        $this->db = $this->connect();
        $this->analyzeTableStruct();
        $row = array();
        $this->db = self::connect();
        if ($id != 0) {
            return $this->get($id);
        }
        //$this->row['id'] = ':SDLK';
        //$this->generateInsertQuery();
    }

    public function fieldRules() {
        return array();
    }

    /**
     * get all the basic structure of the table according to model name
     * set to $this->table
     */
    protected function analyzeTableStruct() {
        //get the table name according to model name 
        if (empty($this->tableName)) {
            $tableName = $this->setTableName();
        } else {
            $tableName = $this->tableName;
        }
        //$fieldRules = $this->fieldRules();
        //querry table structure
        $table = $this->db->query("pragma table_info(" . $tableName . ")");
        //building the structure
        while ($col = $table->fetchArray()) {
            //print_r($col);
            $this->table[$col['name']] = array(
                'colName' => $col['name'], // Name of colum in the database
                'name' => $this->getFieldRule($col['name'], 'name'), // name definition
                'type' => $col['type'], // data type of the colum
                'maxLength' => $this->getFieldRule($col['name'], 'maxLength'), // the length of the col in the table
                'minLength' => $this->getFieldRule($col['name'], 'minLength'),
                'required' => ($this->getFieldRule($col['name'], 'required')) ? $this->getFieldRule($col['name'], 'required') : $col['notnull'], // is the colum value
                'unique' => $this->getFieldRule($col['name'], 'unique'), // default is unique = none
                'regEx' => $this->getFieldRule($col['name'], 'regEx'), //regular expression
                'default' => $col['dflt_value'],
                'pk' => $col['pk'], // is pk
            );
            //echo $col['name'].'|'.$col['type'].'<br />';
        }
        //print_r($this->table);
    }

    private function getFieldRule($colname, $rulename) {
        $fieldRules = $this->fieldRules();
        //print_r($fieldRules);
        if (isset($fieldRules[$colname][$rulename])) {
            //echo $fieldRules[$colname][$rulename];
            return $fieldRules[$colname][$rulename];
        } else {
            return false;
        }
    }

    /**
     * get value of a cell with it's name
     * return value of the cell if it exist
     * return false if the cell is empty
     */
    public function getVal($cellName) {
        if (isset($this->table[$cellName])) {
            return $this->row[$cellName];
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $cellName
     * @param type $value
     * @return false if can't set
     */
    public function setVal($cellName, $value) {
        if (isset($this->table[$cellName])) {
            $this->row[$cellName] = $value;
        } else {
            echo 'the data row you are trying to put is not existed';
            return false;
        }
    }

    /**
     * get the data that the model is holding
     * @return type
     */
    public function getData() {
        return empty($this->row) ? false : $this->row;
    }

    /**
     * set table name in to class proterty and return it
     * @return string Table Name
     */
    protected function setTableName($tableName = "") {
        //get table prefix from config file
        if (empty($tableName)) {
            $prefix = CT::$_CONFIG['db']['tablePrefix'];
            $this->tableName = $prefix . strtolower(get_class($this));
            return $this->tableName;
        } else {
            $this->tableName = $tableName;
            return $tableName;
        }
    }

    /**
     * get table name
     */
    public function getTableName() {
        return $this->tableName;
    }

    /**
     * Delete id of the item in default table
     * @param int $id id of the item you want to delete
     */
    public function delete() {
        if (!empty($this->row['id'])) {
            return $this->db->exec('DELETE FROM ' .
                            $this->tableName .
                            ' WHERE id=' .
                            $this->row['id']);
        } else {
            return false;
        }
    }

    /**
     * Get the data with in the table with id = $id
     * Store that data in $this->row
     * @param int $id
     * @return array of the data if $id exist
     * @return false when $id not exist
     */
    public function get($id) {
        if ($product = $this->exists($id)) {
            foreach ($this->table as $cell) {
                //print_r($cell);
                $this->row[$cell['colName']] = $product[$cell['colName']];
            }
            return ($this->row);
        } else {
            return false;
        }
    }

    /**
     * Load model with model name
     * @param String name of the model you want to load.
     */
    static function loadModel($model) {
        $path = BASE_PATH . '/protected/models/' . $model . '.php';
        if (file_exists($path)) {
            require $path;
            return new $model();
        } else {
            Bootstrap::error('Can not load the model');
        }
    }

    /**
     * get table structure
     * @return array table structure
     */
    public function getTableStruct() {
        return $this->table;
    }

    /**
     * check if a record in database with id = $id exists
     * if it does't, return false, if it does, return the sqlite3result object
     */
    public function exists($id) {
        $result = $this->db->query(
                'SELECT * FROM '
                . $this->tableName .
                ' WHERE id=' . $id
        );
        if ($row = $result->fetchArray()) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * check if all the value of the $row is empty
     */
    protected function isRowEmpty() {
        foreach ($this->row as $val) {
            if (!empty($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * create a new record with the data inside the row
     */
    public function create() {
        //if id in the row is not empty
        if (!empty($this->row['id'])) {
            //check if the id already existed
            if ($this->exists($this->row['id'])) {
                //if id already existed, abort create, return false
                return false;
            }
        }
        return $this->prepareCreate();
    }

    /**
     * update all the information stored in $this->row to database
     */
    public function update() {
        if (isset($this->row['id'])) {
            //if the id in the data is set
            if (!empty($this->row['id'])) {
                //if the id in the data row has value
                if (!$this->exists($this->row['id'])) {
                    return false;
                } else {
                    return $this->prepareUpdate();
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * detech change, return model objet with current ID and the field which 
     * change stored in row data of this model 
     */
    public function changesFilter() {
        if (isset($this->row['id'])) {
            if (!empty($this->row['id'])) {
                $modelName = get_class($this);
                $model = new $modelName();
                $model->setVal('id', $this->row['id']);
                $origin = new $modelName();
                $origin->get($this->row['id']);
                foreach ($this->row as $colName => $val) {
                    if ($origin->getVal($colName) != $val) {
                        $model->setVal($colName, $val);
                    }
                }
                return $model;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * prepare update statement
     */
    private function prepareUpdate() {
        //generate the update query
        $query = $this->generateUpdateQuery();
        //echo $query;
        //prepare the statement
        $stmt = $this->prepareStmt($query);
        $result = $stmt->execute();
        if ($result) {
            //echo 'up dated rows: ', $this->db->changes();
            return $result;
        } else {
            echo $this->db->lastErrorMsg();
            return false;
        }
    }

    private function prepareCreate() {
        $query = $this->generateInsertQuery();
        $stmt = $this->prepareStmt($query);
        //print_r($stmt);
        $stmt->execute();
        return $this->db->lastInsertRowID();
    }

    /**
     * 
     * @return Strng the query to insert with bind value
     */
    private function generateInsertQuery() {
        $query = 'INSERT INTO ' . $this->tableName . ' (';
        foreach ($this->table as $cell) {
            //only add variable to the query if 
            //the data is set and either the colum is not id or if it is id,it
            //cant be null
            if (($cell['colName'] != 'id' || !empty($this->row['id'])) && isset($this->row[$cell['colName']])) {
                $query .= $cell['colName'] . ', ';
            }
        }
        $query .= ') VALUES (';
        foreach ($this->table as $cell) {
            //only add variable to the query if 
            //the data is set and either the colum is not id or if it is id,it
            //cant be null
            if (($cell['colName'] != 'id' || !empty($this->row['id'])) && isset($this->row[$cell['colName']])) {
                $query.= ':' . $cell['colName'] . ', ';
            }
        }
        $query .= ')';
        $query = str_replace(', )', ' )', $query);
        return $query;
    }

    /**
     * 
     * @return string the query
     */
    private function generateUpdateQuery() {
        //generate the update querry
        $query = 'UPDATE ' . $this->tableName . ' SET ';
        foreach ($this->table as $cell) {
            if (isset($this->row[$cell['colName']])) {
                $val = $this->row[$cell['colName']];
                if ($cell['colName'] != 'id' && !empty($val) || $val == 0) {
                    $query .= $cell['colName'] . '=:' . $cell['colName'] . ', ';
                }
            }
        }
        $query = substr_replace($query, "", -2);
        $query .= " WHERE id=:id";
        //echo $query . '</br>';
        return $query;
    }

    /**
     * prepare the statement acording to the data in the db
     * @return preparedStatement 
     */
    private function prepareStmt($query) {
        $stmt = $this->db->prepare($query);
        //automatic bind value for param
        foreach ($this->table as $cell) {

            if (($cell['colName'] != 'id' || !empty($this->row['id'])) && isset($this->row[$cell['colName']])) {
                //echo $cell['colName'].' | '.$cell['type'].' ABOUT TO BE binded with value '.(int)$this->row[$cell['colName']].'<br/>' ;
                $val = $this->row[$cell['colName']];
                switch ($cell['type']) {
                    case 'INTEGER': {
                            $stmt->bindValue(':' . $cell['colName'], (int) $val, SQLITE3_INTEGER);
                            break;
                        }
                    case 'TEXT': {
                            $stmt->bindValue(':' . $cell['colName'], $val, SQLITE3_TEXT);
                            break;
                        }
                    case 'FLOAT': {
                            $stmt->bindValue(':' . $cell['colName'], (float) $val, SQLITE3_FLOAT);
                            break;
                        }
                    case 'BOOL': {
                            $stmt->bindValue(':' . $cell['colName'], (int) $val, SQLITE3_INTEGER);
                            break;
                        }
                    default:
                        //echo 'binding '.$cell['colName'].' value: '.$this->row[$cell['colName']].'<br>';
                        $stmt->bindValue(':' . $cell['colName'], $val);
                        break;
                }
            }
        }
        return $stmt;
    }

    /**
     * check if that colum in the corresponding table exist
     * @param string $colName name of the colum you want to check
     */
    public function hasCol($colName) {
        return isset($this->table[$colName]);
    }

    /**
     * get all value in the array and stored in 
     * @param type $dataArr
     */
    public function setData($dataArr) {
        foreach (array_keys($dataArr) as $colName) {
            if ($this->hasCol($colName)) {
                $this->row[$colName] = $dataArr[$colName];
            }
        }
    }

    /**
     * get an array of model with condition
     */
    public function changesThanOrigin() {
        if (isset($this->row['id'])) {
            if (!empty($this->row['id'])) {
                $data = $this->getData();
                $origin = $this->get($this->row['id']);
                foreach (array_keys($data) as $key) {
                    if ($data[$key] != $origin[$key]) {
                        $this->setData($data);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * get a list of self models which matched condition
     */
    public function getWhere($condition) {
        $query = 'SELECT id FROM ' . $this->tableName . " WHERE " . $condition;
        $className = get_class($this);
        $result = $this->db->query($query);
        if ($result) {
            $models = array();
            while ($id = $result->fetchArray()) {
                $model = new $className($id['id']);
                array_push($models, $model);
            }
            return $models;
        } else {
            return false;
        }
    }

    /**
     * Check if the information as stored in $row already existed in 
     * the database
     */
    public function checkExists() {
        $models = $this->select();
        return (count($models) == 0) ? false : true;
    }

    /**
     * With the condition value set inside the model $row value, execute the 
     * select query with that condition and return an array of self models
     * @return boolean|array False if failed to execute the query, 
     * else array of models
     */
    public function select() {
        $query = $this->prepareSelect();
        $stmt = $this->prepareStmt($query);
        $results = $stmt->execute();
        if (!$results) {
            return false;
        } else {
            $modelName = get_class($this);
            $models = array();
            while ($row = $results->fetchArray()) {
                $model = new $modelName();
                $model->setData($row);
                array_push($models, $model);
            }
            return $models;
        }
    }

    /**
     * prepare the select statement with conditions corresponding
     * @return string the query for select
     */
    private function prepareSelect() {
        $query = "SELECT * FROM " . $this->tableName . " WHERE ";
        if (!empty($this->row)) {
            $keys = array_keys($this->row);
            foreach ($keys as $key) {
                $query .= $key . "=:" . $key . " AND ";
            }
            $query = substr_replace($query, "", -4);
        } else {
            return "current table is empty";
        }
        //echo $query;
        return $query;
    }

    public function validateUpdate() {
        $hasErrs = array();
        foreach ($this->row as $fieldName => $val) {
            if ($fieldName != 'id') {
                $hasErrs[$fieldName] = !$this->validateCell($this->table[$fieldName]);
            }
        }
        foreach ($hasErrs as $hasErr) {
            if ($hasErr) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate the information stored in model data before insert into database
     * using those information
     * 
     * @return array of error message if there is something wrong
     * @return FALSE if no error occurs
     */
    public function validateCreate() {
        $hasErrs = array();
        foreach ($this->table as $cell) {
            if ($cell['colName'] != 'id') {
                $hasErrs[$cell['colName']] = !$this->validateCell($cell);
            }
        }
        //print_r($hasErrs);
        foreach ($hasErrs as $hasErr) {
            if ($hasErr) {
                return false;
            }
        }
        return true;
    }

    public function validateCell($cell) {
        $fieldName = $cell['colName'];
        //echo 'checking '.$fieldName.'<br>';
        if ($this->validateRequired($fieldName)) {
            $fieldValue = isset($this->row[$fieldName]) ?
                    $this->row[$fieldName] : "";
            if (!empty($fieldValue)) {
                if ($this->validateType($fieldName, $fieldValue)) {
                    if ($this->validateRegEx($fieldName, $fieldValue)) {
                        if ($this->validateUnique($fieldName, $fieldValue)) {
                            $hasErr = false;
                        } else {
                            $hasErr = true;
                        }
                    } else {
                        $hasErr = true;
                    }
                } else {
                    $hasErr = true;
                }
            } else {
                $hasErr = false;
            }
        } else {
            $hasErr = true;
        }
        return !$hasErr;
    }

    public function validateRequired($fieldName) {
        $fieldRules = $this->table[$fieldName];
        if ($fieldRules['required']) {
            if (isset($this->row[$fieldName])) {
                $fieldValue = $this->row[$fieldName];
                //$fieldValue = $this->row[$fieldName];
                if (!empty($fieldValue) || $fieldValue === 0) {
                    return true;
                } else {
                    echo $this->getLabel($fieldName) . ' can not be empty </br>';
                    return false;
                }
            } else {
                if (isset($fieldRules['default'])) {
                    return true;
                } else {
                    echo $this->getLabel($fieldName) . ' need to be set </br>';
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    public function validateUnique($fieldName, $fieldValue) {
        $fieldRules = $this->table[$fieldName];
        if ($fieldRules['unique']) {
            $modelClass = get_class($this);
            $model = new $modelClass();
            $model->setVal($fieldName, $fieldValue);
            if ($model->checkExists()) {
                echo $this->getLabel($fieldName) . " already existed<br>";
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function validateType($fieldName, $fieldValue) {
        $fieldRules = $this->table[$fieldName];
        switch ($fieldRules['type']) {
            case 'FLOAT'://validate if type = float
                if (filter_var($fieldValue, FILTER_VALIDATE_FLOAT)) {
                    $valid = true;
                    if (!empty($fieldRules['maxLength']) || $fieldRules['maxLength'] == 0) {
                        if ((float) $fieldValue > (float) $fieldRules['maxLength']) {
                            echo $this->getLabel($fieldName) . " has to be smaller than or equal to " . $fieldRules['maxLength'];
                            $valid = false;
                        }
                    }
                    if (!empty($fieldRules['minLength']) || $fieldRules['minLength'] == 0) {
                        //echo 'min val ='.$fieldRules['minLength'].' | fieldVal = '.$fieldValue;
                        if ((float) $fieldValue < (float) $fieldRules['minLength']) {
                            echo $this->getLabel($fieldName) . " has to be bigger than or equal to " . $fieldRules['minLength'];
                            $valid = false;
                        }
                    }
                    return $valid;
                } else {
                    echo $this->getLabel($fieldName) . ' has to be a float</br>';
                    return false;
                }
                break;
            case 'INTEGER': // validate if type = INTEGER;
                if (filter_var($fieldValue, FILTER_VALIDATE_INT)) {
                    $valid = true;
                    if (!empty($fieldRules['maxLength'])) {
                        if ((int) $fieldValue > (int) $fieldRules['maxLength']) {
                            echo $this->getLabel($fieldName) . " has to be smaller than or equal to " . $fieldRules['maxLength'];
                            $valid = false;
                        }
                    }
                    if (!empty($fieldRules['minLength'])) {
                        //echo 'minLength ='.$fieldRules['minLength'];
                        if ((int) $fieldValue < (int) $fieldRules['minLength']) {
                            echo $this->getLabel($fieldName) . " has to be bigger than or equal to " . $fieldRules['minLength'];
                            $valid = false;
                        }
                    }
                    return $valid;
                } else {
                    return false;
                    echo $this->getLabel($fieldName) . ' has to be a integer number';
                }
                break;
            case 'BOOL':
                if (filter_var($fieldValue, FILTER_VALIDATE_BOOLEAN)) {
                    return true;
                } else {
                    return false;
                    echo $this->getLabel($fieldName) . ' has to be a Boolean</br>';
                }
                break;
            default :
                $length = strlen($fieldValue);
                $valid = true;
                if (!empty($fieldRules['maxLength'])) {
                    if ($length > (int) $fieldRules['maxLength']) {
                        echo $this->getLabel($fieldName) . " has to have maximum " . $fieldRules['maxLength'] . ' characters.';
                        $valid = false;
                    }
                }
                if (!empty($fieldRules['minLength'])) {
                    if ($length < (int) $fieldRules['minLength']) {
                        echo $this->getLabel($fieldName) . " has to have minimum " . $fieldRules['minLength'] . ' characters.';
                        $valid = false;
                    }
                }
                return $valid;
        }
    }

    /**
     * Validate the RegEx pattern
     * @param type $fieldName
     * @param type $fieldValue
     * @return boolean
     */
    public function validateRegEx($fieldName, $fieldValue) {
        $fieldRules = $this->table[$fieldName];
        if ($regExPatt = $fieldRules['regEx']) {
            if (preg_match($regExPatt, $fieldValue)) {
                return true;
            } else {
                echo 'Invalid ' . $this->getLabel($fieldName);
                return false;
            }
        } else {
            return true;
        }
    }

    /*     * get label for a field* */

    public function getLabel($fieldName) {
        $fieldRules = $this->table[$fieldName];
        return ( empty($fieldRules['name'])) ? $fieldRules['colName'] : $fieldRules['name'];
    }

    public function __destruct() {
        $this->db->close();
        unset($this->db);
    }
}
