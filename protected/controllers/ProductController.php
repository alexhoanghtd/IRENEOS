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
            $picture = new Pictures();
            $pictureUrls = $picture->getProductPictures($id);
            $this->render('view', array(
               'model'=>$model->getData(),
               'pictureUlrs'=>  $pictureUrls,
            ));
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
            //create product with the val get from form
            if ($model->create()) {
                $productName = $model->getVal('product_name');
                echo 'product' . $productName . ' created succesfuly! :)<br/>';
                $productID = $model->getProductIdByName($productName);
                $folderName = $model->generateFolderName();
                echo 'folder: '.$folderName.'<br/>';
                //create a folder acording to the product name
                if (Pictures::createPictureFoler($folderName)) {
                    //if create folder sucessfully
                    foreach (array_keys($_FILES) as $key) {
                        if ($_FILES[$key]['error'] == 0) {
                            //create a new picture model 
                            $pic = new Pictures();
                            //set product_id for the pic
                            $pic->setVal('product_id', $productID);
                            //set the product name associated with the picture
                            $pic->setVal('name', $productName);
                            if ($url = $pic->uploadPicture($_FILES[$key], $folderName)) {
                                if ($key == 'cover') {
                                    $pic->setVal('type', 1);
                                } else {
                                    $pic->setVal('type', 2);
                                }
                                //if upload that picture sucessfully, save 
                                //information about that picture to database
                                $pic->setVal('url', $url);
                                print_r($pic->getData());
                                if ($pic->create()) {
                                    echo 'save picture sucessfully <br/>';
                                } else {
                                    echo 'save picture failed <br/>';
                                }
                            }else{
                                echo 'failed to upload the picture';
                            }
                        } else {
                            echo 'picture has error';
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

    public function actionTest() {
        $model = new Product();
        $folderName = $model->seoFriendLy('Nina very super Black');
        Pictures::createPictureFoler($folderName);
    }

}
