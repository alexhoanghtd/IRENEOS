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

            //is this correct??
            // print_r to find out
            print_r($user->getData());

            $currUser = $user->select();
            if($currUser){
                //if user entered correctly
                //get role according to dat user
                // and redirect to da right part
                CT::user()->setRole($currUser[0]->getVal('role'));
                if(CT::user()->getRole() == CT_ADMIN){
                    //get user's id after logged in and push to custom user data
                    CT::user()->setUserData('userId',$currUser[0]->getVal('id'));

                    CT::redirect_to("/Admin/");
                }else{
                    CT::user()->setUserData('userId',$currUser[0]->getVal('id'));
                    CT::redirect_to("/");
                }
            }else{
                //if user mistype or smthing wrong happened
                echo 'username or password is incorrect <br/>';
            }
        }  
        if ($this->isAjax()) {
            $this->renderAjax('login', '');
        } else {
            CT::widgets('MainMenu')->setActive(USER_MENU, 'login');
            $this->render('login', '');
        }
    }

    function actionLogout() {
        if (CT::user()->getRole() != CT_VISITOR) {

            //set role to visitor
            CT::user()->setRole(CT_VISITOR);
            
            //reset all user custom data
            CT::user()->resetDatas();

            //redirect to home page
            CT::redirect_to("/");
            // echo "you have logged out <br />";
        } else {
            CT::redirect_to("/");
            // echo "what do you think you're doing huh??? <br />";
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

            //print_r($user->getTableStruct());
            if($user->validateCreate()){
                if ($user->create()) {
                    $userName = $user->getVal('username');
                    echo 'User ' . $userName . ' created successfully! <br />';
                    $userID = $user->getUserIdByName($userName);

                    $folderName = "avatars";

                    if ($_FILES["avatar"]["error"] == 0) {
                        $pic = new Pictures();
                        //set user's id for dat pic
                        $pic->setVal('user_id', $userID);
                        //get name for dat pic according to username
                        $pic->setVal('name', $userName);

                        if (Pictures::uploadPicture($_FILES["avatar"], $folderName)) {
                            /*after dat pic had already uploaded
                            *do all these things
                            *rename the pic followed by username
                            *set type
                            *and set url
                            *to push to db
                            */

                            //getting extension of the uploaded pic
                            $picInfo = new SplFileInfo($_FILES["avatar"]["name"]);
                            $picExt = $picInfo->getExtension();

                            //rename 
                            $oldPicName = BASE_PATH . "/images/" . $folderName . "/" . $_FILES["avatar"]['name'];
                            $newPicName = BASE_PATH . "/images/" . $folderName . "/" . $userName . "." . $picExt;
                            rename($oldPicName, $newPicName);

                            //set type
                            $pic->setVal('type', 9);

                            //set url
                            $url = "/images/" . $folderName . "/" . $userName . "." . $picExt;
                            $pic->setVal('url', $url);

                            //save pic's infos to bd
                            if ($pic->create()) {
                                echo "pic's infos successfully saved to db <br/>";
                            } else {
                                echo "pic's infos CANNOT be saved to db <br/>";
                            }
                        } else {
                            echo "picture upload failed <br/>";
                        }
                    }
                }
            } else {
                echo 'xomexing dzong??? <br/>';
            }
        }
        $this->render('register', '');
    }

}
