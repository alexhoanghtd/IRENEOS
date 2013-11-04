<?php

/**
 * Keeptrack of all individual user Identity and data in the operation
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */

class Shopper extends CTUser implements IUserIdentity{
    
    private $bag;
    public function __construct() {
        parent::__construct();
        $this->bag = new Bag();
        //$this->setRole(CT_VISITOR);
    }
    
    public function addToBag($bagItem){
        $this->bag->add($bagItem);
        $_SESSION['user'] = serialize($this);
    }
    public function bag(){
        //$this->showUserData();
        return $this->bag;
    }
    

}