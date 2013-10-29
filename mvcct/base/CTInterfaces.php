<?php
/**
 * Define intefaces for classes that can generate an HTML page
 * from a view
 */
interface IViewGenerate{
    
}
interface IDBRecord{
    public function ShowTableStruct();
    public function getTableName();
    public function getData();
    public function updateData();
    public function delete();
    public function create();
}