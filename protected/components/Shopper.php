<?php

/**
 * Keeptrack of all individual user Identity and data in the operation
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */

class Shopper extends CTUser implements IUserIdentity{
    public function __construct() {
        parent::__construct();
        //echo 'shopper component loaded';
    }
    

}