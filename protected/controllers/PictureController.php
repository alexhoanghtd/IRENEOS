<?php

/**
 * Controller that control picture in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class PictureController extends CTController{
    public function actionIndex() {
    }
    
    public function actionSlide($productID){
        if($this->isAjax()){
            $urls = Pictures::getProductPictures($productID);
            $this->renderAjax('slider', $urls);
        }
    }
}