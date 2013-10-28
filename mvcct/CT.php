<?php
//define the base path to CTMVC
define ('CT_PATH', dirname(__FILE__));
//add the base classes
$includes = array(
   '/base/CTComponent.php',
   '/base/CTWidget.php',
   '/Bootstrap.php',
   '/base/CTController.php',
   '/base/CTModel.php',
   '/base/CTView.php',

);

foreach($includes as $file) {
     include_once dirname(__FILE__).$file;
}

/*
 * This class is bascially static and it does:
 * create a bootstrap class, start to deal with mvc
 * get the system config from the app itself
 */
class CT{
   //static configuration for the app
   static $_CONFIG = array();
   static private $widgets = array();
   /*
    *start the application load the config and start bootstrap
    */   
   public function run($config) {
       CT::$_CONFIG = CT::getConfig($config);
       //print_r(CT::$_CONFIG)
       CT::loadWidgets();
       $bootstrap = new Bootstrap();
   }

   public static function baseURL(){
       return 'http://'.$_SERVER['SERVER_NAME'];
   }
    
   /*
    * function to get configuration when the app started
    */
   private function getConfig($config){
        return require $config;
   }
   public static function config(){
       return CT::$_CONFIG;
   }
   public static function widgets($widgetName){
       return CT::$widgets[$widgetName];
   }
   /**
    * 
    */
   private function loadWidgets(){
       $widgetNames = array_keys(CT::$_CONFIG['widgets']);
       $widgets = CT::$widgets;
       foreach($widgetNames as $widgetName){
           require BASE_PATH.'/protected/widgets/'.$widgetName.'.php';
           //push a new widget to widget list of the app
           if(!isset(CT::$widgets[$widgetName])){
               CT::$widgets[$widgetName] = new $widgetName();
           }
       }
   }
}
 
   //print_r($bootstrap->getConfig());
