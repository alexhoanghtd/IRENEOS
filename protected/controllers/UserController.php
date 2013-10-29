<?php
/**
 * UserController 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */

//fuck this shit! im so tired right now :P


class UserController extends CTController{
    public function actionTestGetUser($id) {
        //$model = $this->loadModel('User');
        //$userData = $model->getUser($id);
        //this->render
        $id=1;
        if (!empty($id)) {
            $model = $this->loadModel('User');
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

    public function actionTestGetUserRole($id) {
        //$model = $this->loadModel('User');
        //$userData = $model->getUser($id);
        //this->render
        $id=1;
        if (!empty($id)) {
            $model = $this->loadModel('User');
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
}