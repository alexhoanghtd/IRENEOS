<?php

/**
 * Base sqlite database class
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 25 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */

class CTSQLite extends SQLite3{
    
    public function __construct($filename, $flags = null, $encryption_key = null) {
        parent::__construct($filename, $flags, $encryption_key);
    }
    /**
     * connect to sqlite database file with config stored
     * @return \SQLite3
     */
    public static function connect(){
        $dbInfo = CT::$_CONFIG['db'];
        $connStr = $dbInfo['connectionString'];
        return new SQLite3(BASE_PATH.$connStr);
    }    
}