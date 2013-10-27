<?php

/**
 * Controller that control item's category in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CategoryController extends CTController{
    
    public $layout = 'main';
    /**
     * Default action for category.
     * This method will show user the list of categories existed in the system.
     * @return none
     */
    function actionIndex() {
        //load data for category which will be shown
        CT::widgets('MainMenu')->setActive('visit store');
        $this->render('index','example Data');
    }

}
