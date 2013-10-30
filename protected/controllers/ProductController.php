<?php

/**
 * Controller that control products in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class ProductController extends CTController {

    /**
     * By default when user try to type in product controller with index action
     * it will get user to the category page
     */
    public function actionIndex() {
        /* Redirect browser */
        header("Location: http://irene.local/Category/");
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    }

    /**
     * show the product with id = $id
     * @param int $id of the product
     */
    public function actionView($id) {
        if (!empty($id)) {
            $model = new Product();
            $model->get($id);
            $model->setVal('id', 14);
            $this->render('view', 'xampleData');
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    /**
     * Action to create a new product
     */
    public function actionCreate() {
//        if(isset($_FILES)){
//            print_r($_FILES);
//        }
        $picture = new Pictures();
        $picture->uploadPicture($_FILES['cover']);
        if (isset($_POST['product'])) {
            $product = $_POST['product'];
            $model = new Product();
            $model->setData($product);
        }
        $this->layout = 'main';
        $this->render('create', 'example');
    }
    
    /**
     * update a product info
     */
    public function actionUpdate(){
        
    }
}
