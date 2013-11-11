<?php

/**
 * SiteController 
 * COntroller to control the default index page, log in, logout and other function
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @author duyht <duyht@smartosc.com>
 * @created 26 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class SiteController extends CTController {

    function actionIndex() {
        $this->layout = 'collection';
        $newArrival = 'data of new arrival collection';
        //$collection = $this->loadModel('collection');
        //$newArrival = $collection->getCollection(1);
        $this->render("index", $newArrival);
    }
    /**about page
    function actionAbout() {
        CT::widgets('MainMenu')->setActive(USER_MENU, 'about us');
        $this->render('about', 'xampledata');
    }
    /**
     * contact page
     */
    function actionContact() {
        CT::widgets('MainMenu')->setActive(USER_MENU, 'contact us');
        $this->render('about', 'xampledata');
    }

    /*     * form login* */

    function actionLogin() {
        CT::widgets('MainMenu')->setActive(USER_MENU, 'login');
        $this->render('login', '');
    }
    function actionSignup(){
        CT::widgets('MainMenu')->setActive(USER_MENU,'login');
        $this->render('register','');
    }
}
