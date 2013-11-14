<?php
/**
 * UserController 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

class UserController extends CTController{
    public function actionListUsers() {
        
    }

    public function actionGetUser($id) {
        //$model = $this->loadModel('User');
        //$userData = $model->getUser($id);
        //this->render
        if (!empty($id)) {
            $model = new User();
            $row = $model->getUser($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userData = $row;
                print_r($userData);
            }
        }else{
            header("Location: http://irene.local/");
        }
    }

    public function actionGetUserRole($id) {
        
        if (!empty($id)) {
            $model = new User();
            $row = $model->getUserRole($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userRole = $row;
                echo "Get User's role successful! Role is " .$userRole;
            }
        }else{
            header("Location: http://irene.local/");
        }
    }

    public function actionBlockUser($id) {
        
        if (!empty($id)) {
            $model = new User();
            $row = $model->blockUser($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userName = $row;
                echo "Block user successful! User name is " .$userName;
            }
        }else{
            header("Location: http://irene.local/");
        }
    }
}