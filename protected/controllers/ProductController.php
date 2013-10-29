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
            $model->setVal('product_name','alex testimony');
            print_r($model->getData());
            $model->create();
            //$model->update();
            //print_r($model->get($id));
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    public function actionCreate() {
        $this->layout = 'admin';
        $this->render('create', 'example');
    }

}
