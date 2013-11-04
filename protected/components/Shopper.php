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

        $this->save();
    }
    
    public function bagAddUp($attID){
        $this->bag->bagAddUp($attID);
        //$this->bag->listAll();        
        $this->save();
    }
    
    public function bagSubDown($attID){
        echo 'about to sub down';
        $this->bag->bagSubDown($attID);
        //$this->bag->listAll();        
        $this->save();
    }
    public function remove($productID){
        $this->bag->removeItem($productID);
        $this->save();
    }
    public function removeAtt($attID){
        $this->bag->removeAtt($attID);
        $this->save();
    }
    public function bag(){
        //$this->showUserData();
        return $this->bag;
    }
    

}