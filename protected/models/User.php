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
    //get all user's infos
    public function getUser($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){
            
            return $row;
        }else{
            return false;
        }
    }
    
    //get user's role
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

    //block user that (hacking, violate rules,.... etc)
    public function blockUser($id){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){

            $blockUserQuery = 'UPDATE ic_user SET active=0 WHERE id='.$id;
            $this->db->query($blockUserQuery);

            $userName = $row['username'];
            return $userName;
        }else{
            return false;
        }
    }

    //authorize login and return user's role
    public function isAuthorize($username, $password){
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id='.$id);
        if($row = $results->fetchArray()){
            if ($username == $row['username'] && $password == $row['password']) {
                return $row['role'];
            }        
        }else{
            return false;
        }
    }

    //check required fields
    public function checkRequiredFields($required_array) {
        $field_errors = array();
        foreach ($required_array as $fieldname) {
            if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] !=0)) {
                $field_errors[] = $fieldname;
            }
        }
        return $field_errors;
    }

    //check for field that requires max length

    //confirm query
    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed: " . sqlite_error());
        }
    }

    //validate login informations
    public function validateLogin() {
        if (isset($_POST['submit'])) {
            $errors = array();

            $required_fields = array('username', 'password');
            $errors = array_merge($errors, checkRequiredFields($required_fields));

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($errors)) {
                $conn = CTSQLite::connect();


                //check database if user and password exist
                $query = "SELECT id, username ,role ";
                $query .= "FROM ic_user ";
                $query .= "WHERE username = '{$username}' ";
                $query .= "password = '{$password}' ";
                $query .= "LIMIT 1";

                $result = $conn->query($query);
                confirm_query($result);
                
                if(sqlite_num_rows($result) == 1){
                    $user = $result->fetchArray();
                    $role = $user['role'];
                    CT::user()->setRole($role);
                }
            } else {
                if (count($errors) == 1) {
                    // 1 error ocurred
                    $message = "There was 1 error in the form";
                } else {
                    //more than 1 error occured
                    $message = "There were" . count($errors) . "errors in the form";
                }
            }
        } else {
            //form has not been submitted
        }
    }
}
