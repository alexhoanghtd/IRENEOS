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

    /** about page
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
        if(isset($_POST['login'])){
            $loginData = $_POST['login'];
            $user = new User();
            $user->setVal('username',$loginData['username']);
            $user->setVal('password',$loginData['password']);
            print_r($user->getData());
            $currUser = $user->select();
            if($currUser){
                CT::user()->setRole($currUser[0]->getVal('role'));
                if(CT::user()->getRole() == CT_ADMIN){
                    CT::redirect_to("/Admin/");
                }else{
                    CT::redirect_to("/");
                }
            }else{
                echo 'username or password is incorrect';
            }
        }  
        if ($this->isAjax()) {
            $this->renderAjax('login', '');
        } else {
            CT::widgets('MainMenu')->setActive(USER_MENU, 'login');
            $this->render('login', '');
        }
    }

    function actionSignup() {
        CT::widgets('MainMenu')->setActive(USER_MENU, 'login');
        if (isset($_POST['register'])) {
            $registerData = $_POST['register'];
            $user = new User();
            $user->setData($registerData);
            $user->setVal('role',CT_USER);
            $user->setVal('email_veryfied',0);
            print_r($user->getTableStruct());
            if($user->validateCreate()){
                echo 'something wrong';
            }
        }
        $this->render('register', '');
    }

}
