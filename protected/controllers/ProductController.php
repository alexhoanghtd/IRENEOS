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
            $model->setVal("product_name", "alex's fashion");
            $model->update();
            $this->render('view', 'xampleData');
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    /**
     * Action to create a new product
     */
    public function actionCreate() {
        if (isset($_POST['product'])) {
            $product = $_POST['product'];
            $model = new Product();
            $model->setData($product);
            if ($model->create()) {
                $productName = $model->getVal('product_name');
                echo 'product' .$productName. ' created succesfuly! :)<br/>';
                $productID = $model->getProductIdByName($productName);
                echo 'product id = '.$productID.'<br/>';
                foreach (array_keys($_FILES) as $key) {
                    if ($_FILES[$key]['error'] == 0) {
                        $pic = new Pictures();
                        $pic->setVal('product_id',$productID);
                        $pic->setVal('name', $productName);
                        if($url = $pic->uploadPicture($_FILES[$key])){
                            if($key = 'cover'){
                                $pic->setVal('type', 1);
                            }else{
                                $pic->setVal('type', 2);
                            }
                            $pic->setVal('url', $url);
                            if($pic->create()){
                                echo 'upload picture sucessfully';
                            }
                            else{
                                echo 'upload picture failed';
                            }
                        }
                        
                    }
                }

            }
        }
        $this->layout = 'main';
        $this->render('create', 'example');
    }

    /**
     * update a product info
     */
    public function actionUpdate() {
        
    }

}
