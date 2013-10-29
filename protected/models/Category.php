<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class Category extends CTModel{
    public function getCategory($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_category WHERE is_collection=0 AND id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }

    public function updateCategory($id){

    }

    public function createCategory($id){
        
    }

    public function deleteCategory($id){
        
    }

    public function getCategoryProducts($id){
        
    }
}