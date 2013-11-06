<?php
/**
 * SiteController 
 * COntroller to control the default index page, log in, logout and other function
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 26 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class SiteController extends CTController{
    
    function actionIndex() {
        $this->layout = 'collection';
        $newArrival = 'data of new arrival collection';
        //$collection = $this->loadModel('collection');
        //$newArrival = $collection->getCollection(1);
        $this->render("index",$newArrival);
    }
    
    function actionAbout(){
        CT::widgets('MainMenu')->setActive(USER_MENU,'about us');
        $this->render('about','xampledata');
    }
        function actionContact(){
        CT::widgets('MainMenu')->setActive(USER_MENU,'contact us');
        $this->render('about','xampledata');
    }
}