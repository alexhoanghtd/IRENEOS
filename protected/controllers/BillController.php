<?php

/**
 * Controller that control products in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 23 Nov 2013
 * @copyright &copy; 2013 Creative Team 
 */
class BillController extends CTController{
    public function actionView(){
        $this->render('bill', '');
    }
}