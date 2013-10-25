<?php
//define the base path to CTMVC
define ('CT_PATH', dirname(__FILE__));
//add the Bootstrap class
$includes = array(
   '/Bootstrap.php',
   '/base/CTController.php',
   '/base/CTModel.php',
);

foreach($includes as $file) {
     include_once $file;
}

/*
 * This class is bascially static and it does:
 * create a bootstrap class, start to deal with mvc
 * get the system config from the app itself
 */
$ctControl = new CTController();
class ct{
   //static configuration for the app
   static $_CONFIG;

   /*
    *start the application load the config and start bootstrap
    */   
   public function run($config) {
       ct::$_CONFIG = ct::getConfig($config);
       //print_r(ct::$_CONFIG);
       $bootstrap = new Bootstrap();
   }

   /*
    * function to get configuration when the app started
    */
   private function getConfig($config){
        return require $config;
   }
}
 
   //print_r($bootstrap->getConfig());
