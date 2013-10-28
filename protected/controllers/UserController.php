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
    //$id = 1;
    public function actionTestGetUser($id) {
        //$model = $this->loadModel('User');
        //$userData = $model->getUser($id);
        //this->render
        
        if (!empty($id)) {
            $model = $this->loadModel('User');
            $row = $model->getUser($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userData = $row;
                //not done yet
            }
        }else{
            header("Location: http://irene.local/");
        }
    }
}