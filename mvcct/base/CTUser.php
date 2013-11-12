<?php

/**
 * Base user class
 * if the extended application doesn't want to use this guy,
 * they can create their own user class, extend this guy! :)
 * or write their own (if they are toooo good or just just stupid) lol
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 2 Nov 2013
 * @copyright &copy; 2013 Creative Team 
 */
define('CT_VISITOR', 1);
define('CT_USER', 2);
define('CT_ADMIN', 3);
define('CT_DEVELOPER', 4);

class CTUser extends CTComponent implements IUserIdentity {
    
        private $role;
        private $username;
        private $firstName;
        private $lastName;
        private $data;
    public function __construct() {
        $this->role = CT_VISITOR;
    }
    /**
     * Set custom user Data
     * @param type $key
     * @param type $value
     */
    public function setUserData($key,$value){
        $this->data[$key]=$value;
        $this->save();
    }
    /**
     * get custom user data
     * @param type $key
     * @return type
     */
    public function getUserData($key){
        return $this->data[$key];
    }
    /**
     * dev's shit
     * get all user custom data
     */
    public function getDatas(){
        return $this->data;
    }
    public function setBasicInfo($username,$firstName,$lastName){
        $this->username =$username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->save();
    }
    /**
     * get Username
     * @return type
     */
    public function getUserName(){
        return $this->username;
    }
    /**
     * get first name
     * @return type
     */
    public function getFirstName(){
        return $this->firstName;
    }
    /**
     * 
     * @return typeget last name of the current user
     */
    public function getLastName(){
        return $this->lastName;
    }
    /**
     * set role for current user in the session
     * @param type $role
     */
    public function setRole($role) {
       $this->role = $role;
       $_SESSION['user'] = serialize($this);
    }

    //get the role of the current user
    public function getRole() {
        return $this->role;
    }
    /**
     * Check acess level of current user for a controller
     * @param type $controller
     * @param type $action
     * @return boolean
     */
    public function isAllowed(CTComponent $controller, $action = 0) {

        if ($this->controllerAccess($controller)) {
             if ($action !== 0) {
                if ($this->actionAcess($controller, $action)) {
                    return true;
                }else{
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /*
     * check if user can acess this controller
     * 
     */

    private function controllerAccess(CTComponent $controller) {
        $rules = $controller->rules();
        if ($rules["allow"] == "*") {
            return true;
        } else {
            $allows = $rules['allow'];
            if (in_array($this->getRole(), $allows)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * check if an action is accessible for current user
     * @param CTComponent $controller
     * @param type $action
     */
    private function actionAcess(CTComponent $controller, $action) {
        $rules = $controller->rules();
        if ($rules[$this->getRole()] == "*") {
            return true;
        } else {
            $allows = explode(',', $rules[$this->getRole()]);
            if (in_array($action, $allows)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    protected function save(){
        $_SESSION['user'] = serialize($this);
    }
}
