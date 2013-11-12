<?php

/**
 * Main menu widget 
 * This widget showing
 */
define('USER_MENU', '1');
define('ADMIN_MENU', '2');

class MainMenu {

    private $items;
    private $active;
    private $view;
    private $viewBluePrint;

    private function menuList($menuType) {
        $menuList = array(
            "1" => array(
                'new arrivals' => 'http://irene.local',
                'collections' => '/Collection/',
                'about us' => '/Site/About/',
                'contact us' => '/Site/Contact',
                'visit store' => '/Category/',
                'login' => '/Site/Login/',
                'bag' => '/bag/View',),
            "2" => array(
                'collection' => '',
                'categories' => '',
                'products' => '',
                'users' => '',
                'bills' => '',
                'logout' => '',
            ),
        );
        return $menuList[$menuType];
    }

    public function __construct() {
        //$this->items = CT::$_CONFIG['widgets']['MainMenu'];
        $this->viewBluePrint = 'mainMenu';
        $this->items = $this->menuList(1);
        $this->active = 'new arrivals';
    }

    private function renderMenu() {
        ob_start();
        $viewFile = BASE_PATH . '/protected/widgets/views/' . $this->viewBluePrint . '.php';
        include($viewFile);
        $returned = ob_get_contents();
        ob_end_clean();
        return $returned;
    }

    public function setActive($menuType, $active) {
        $this->items = $this->menuList($menuType);
        $this->active = $active;
    }

    public function show() {
        echo $this->renderMenu();
    }

}
