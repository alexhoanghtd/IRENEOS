<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class Product extends CTModel{
    public function getProduct($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_product WHERE id='.$id);
        if($row = $results->fetchArray()){
            $getPicQuery = 'SELECT * FROM ic_pictures WHERE id='.$row['cover_id'];
            $covers = $this->db->query($getPicQuery);
            $cover = $covers->fetchArray();
            $coverURL = $cover['url'];
            $row['coverURL'] = $coverURL;
            return $row;
        }else{
            return false;
        }
    }

    public function updateProduct($id){

    }

    public function createProduct($id){
        
    }

    public function deleteProduct($id){
        
    }
}