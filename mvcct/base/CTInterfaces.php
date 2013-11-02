<?php

/**
 * Define intefaces for classes that can generate an HTML page
 * from a view
 */
interface IUserIdentity {
}

interface IDBRecord {

    /**
     * get the table struct as array
     * false if not set
     */
    public function getTableStruct();

    /**
     * get table name ( ic_ + table name)
     */
    public function getTableName();

    /**
     *  get array of the stored in the record
     */
    public function getData();

    /**
     * delete the data in database with id according to
     * the id stored in the tata of the record object
     */
    public function delete();

    /**
     * update the data stored in the record object ($row)
     * according to stored id
     */
    public function update();

    /**
     * inerst into database with the data stored in object record ($row)
     * 
     */
    public function create();
    
    /**
     * check if a record in database with id = $id exists
     */
    public function exists($id);
    /**
     * set the information with custom query to the $row data
     * @return bool false if the query has no result
     * @return array of models coresponding to result             
     */
}
