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

    public function actionView($id) {
        //$model = $this->loadModel('Product');
        //$productData = $model->getProduct($id);
        //this->render
        $model = $this->loadModel('Product');
        $row = $model->getProduct($id);
        if (empty($row)) {
            Bootstrap::error('404');
        } else {
            $productData = $row;
            CT::widgets('MainMenu')->setActive('visit store');
            $this->render('view', $productData);
        }
    }

}
