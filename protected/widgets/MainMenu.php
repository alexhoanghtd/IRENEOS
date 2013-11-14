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
    private $menu;
    private $view;
    private $viewBluePrint;

    private function menuList($menuType) {
        $menuList = array(
            "1" => array(
                'new arrivals' => 'http://irene.local',
                'collections' => '/Collection/',
                'visit store' => '/Category/',
                'contact us' => '/Site/Contact',
                'bag' => '/bag/View',
                'login' => '/Site/Login/',
            ),
            "2" => array(
                'collection' => '/Collection/List/',
                'categories' => '/Category/List/',
                'products' => '/Product/List',
                'users' => '/User/List',
                'bills' => '/Bill/List',
                'logout' => '/Site/Logout/',
            ),
        );
        return $menuList[$menuType];
    }

    public function __construct() {
        //$this->items = CT::$_CONFIG['widgets']['MainMenu'];
        $this->viewBluePrint = 'mainMenu';
        $this->items = $this->menuList(1);
        $this->menu = 1;
        $this->active = 'new arrivals';
    }

    private function renderMenu() {
        if(CT::user()->getRole() != CT_VISITOR && $this->menu == 1){
            unset($this->items['login']);
            $this->items['logout'] = '/site/Logout';
        }
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
