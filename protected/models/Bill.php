<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class Bill extends CTModel{
    public function getBill($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_bill WHERE id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }

    public function updateBill($id){

    }

    public function createBill($id){
        
    }

    public function deleteBill($id){
        
    }
}