<?php

/**
 * Controller that control item's category in the system
 * @author trungnt <trungnt1@smartosc.com>
 * @created 30 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CategoryController extends CTController {

    public $layout = 'main';

    /**
     * Default action for category.
     * This method will show user the list of categories existed in the system.
     * @return none
     */
    public function actionIndex() {
        /* Redirect browser */
        header("Location: http://irene.local/");
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    }

    /**
     * show the product with id = $id
     * @param int $id of the product
     */
    function actionView($id) {
        //load data for category which will be shown
        if (!empty($id)) {
            $model = new Category();
            $data = $model->getCategory($id);
            CT::widgets('MainMenu')->setActive('visit store');
            $this->render('view',$data);
        } else {
            header("Location: http://irene.local/");
        }
    }

    public function actionCreate() {
        $model = new Category();
//        $model->setVal('id', 2);
//        $model->setVal('name', 'Hat');
//        print_r($model->getData());
//        $model->create();

        $create = $model->createCategory($_POST['category']);
        $this->layout = 'admin';
        $this->render('create', 'example');
    }

    public function actionDelete(){
        $model = new Category();
        $model->deleteCategory(2);
        
        $this->layout = 'admin';
        $this->render('create', 'example');
    }
}
