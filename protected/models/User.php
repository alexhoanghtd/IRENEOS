<?php
/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

//dont know if its right or not (lol)
//our leader pls review 'em

class User extends CTModel{
    public function getUser($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }
    
    public function getUserRole($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){
            
            $userRole = $row['role'];
            return $userRole;
        }else{
            return false;
        }
    }

    public function blockUser($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){

            $blockUserQuery = 'UPDATE ic_user SET active='0'';
            $this->db->query($blockUserQuery);
            return true;
        }else{
            return false;
        }
    }

    public function isAuthorize($username, $password){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){
            if ($username == $row['username'] && $password == $row['password']) {
                        return true;
                    }        
        }else{
            return false;
        }
    }
}
