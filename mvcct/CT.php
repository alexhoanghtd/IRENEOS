<?php

//define the base path to CTMVC
define('CT_PATH', dirname(__FILE__));
//add the base Components
$includes = array(
    '/base/CTInterfaces.php',
    '/base/CTSQLite.php',
    '/base/CTComponent.php',
    '/base/CTWidget.php',
    '/base/CTController.php',
    '/base/CTModel.php',
    '/base/CTView.php',
    '/base/CTUser.php',
    '/Bootstrap.php',
);

foreach ($includes as $file) {
    include_once dirname(__FILE__) . $file;
}

/*
 * This class is bascially static and it does:
 * create a bootstrap class, start to deal with mvc
 * get the system config from the app itself
 */

class CT {

    //static configuration for the app

    static $_CONFIG = array();
    static private $widgets = array();
    static private $components = array();
    static private $_USER;

    /*
     * start the application load the config and start bootstrap
     */
    public function run($config) {
        //get configuration
        self::$_CONFIG = self::setConfig($config);
        //load user component
        self::$_USER = self::loadUser();
        //load custom component
        self::loadComponents();
        //load widget
        self::loadWidgets();
        //load controller according to developer rules used fo
        $bootstrap = new Bootstrap();
    }

    //public f

    public static function baseURL() {
        return 'http://' . $_SERVER['SERVER_NAME'];
    }

    /*
     * function to get configuration when the app started
     */

    private function setConfig($config) {
        return require $config;
    }

    public static function config() {
        return self::$_CONFIG;
    }

    public static function user() {
        return self::$_USER;
    }

    public static function widgets($widgetName) {
        return self::$widgets[$widgetName];
    }
    /**
     * load components 
     * return the array of component objects
     */
    private static function loadComponents(){
        return array();
    }
    /**
     * Load user component to CT application according to the config file
     */
    private function loadUser() {
        if (isset(self::$_CONFIG['components']['User'])) {
            //if the custom user component is set
            //then set the user of CT as that user component
            $user = self::$_CONFIG['components']['User'];
            require BASE_PATH . '/protected/components/' . $user . '.php';
            $shopper = new $user();
            $shopper->setRole(CT_VISITOR);
            return $shopper;
        } else {
            //else use CT default User component
            return new CTUser();
        }
    }

    /**
     * 
     */
    private function loadWidgets() {
        $widgetNames = array_keys(self::$_CONFIG['widgets']);
        $widgets = self::$widgets;
        foreach ($widgetNames as $widgetName) {
            require BASE_PATH . '/protected/widgets/' . $widgetName . '.php';
            //push a new widget to widget list of the app
            if (!isset(self::$widgets[$widgetName])) {
                self::$widgets[$widgetName] = new $widgetName();
            }
        }
    }

}
