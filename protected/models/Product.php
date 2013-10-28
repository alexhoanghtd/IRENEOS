<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    
}
