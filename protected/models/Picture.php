<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class Picture extends CTModel{
    public function getPicture($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }

    public function updatePicture($id){

    }

    public function createPicture($id){
        
    }

    public function deletePicture($id){
        
    }

    public function getProductPictures($productID){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE product_id='.$productID);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }

    public function getCategoryPictures($categoryID){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE category_id='.$categoryID);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }
}