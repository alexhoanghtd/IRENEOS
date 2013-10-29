<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class Collection extends CTModel{
    public function getCollection($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_category WHERE is_collection=1 AND id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }

    public function updateCollection($id){

    }

    public function createCollection($id){
        
    }

    public function deleteCollection($id){
        
    }

    public function getCollectionProducts($id){
        
    }
}