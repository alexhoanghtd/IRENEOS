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
            $pictureUrls = Pictures::getProductPictures($id);
            $attrs = $model->getProductAttributes();
            $this->render('view', array(
                'model' => $model->getData(),
                'pictureUlrs' => $pictureUrls,
                'attrs' => $attrs,
            ));
        } else {
            header("Location: http://irene.local/Category/");
        }
    }
    public function actionViewAjax($id) {
        if (!empty($id)) {
            $model = new Product();
            $model->get($id);
            $picture = new Pictures();
            $pictureUrls = Pictures::getProductPictures($id);
            $attrs = $model->getProductAttributes();
            $this->renderAjax('view', array(
                'model' => $model->getData(),
                'pictureUlrs' => $pictureUrls,
                'attrs' => $attrs,
            ));
        } else {
            echo 'noproduct available';
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
                //echo 'folder: ' . $folderName . '<br/>';
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
                            if ($url = Pictures::uploadPicture($_FILES[$key], $folderName)) {
                                if ($key == 'cover') {
                                    $pic->setVal('type', 1);
                                } else {
                                    $pic->setVal('type', 2);
                                }
                                $pic->setVal('url', $url);
                                //echo $url;
                                //print_r($pic->getData());
                                if ($pic->create()) {
                                    //echo 'save picture sucessfully <br/>';
                                } else {
                                    //echo 'save picture failed <br/>';
                                }
                            } else {
                                //echo 'failed to upload the picture';
                            }
                        } else {
                            //echo 'picture has error';
                        }
                    }
                }
            }
        }
        CT::widgets('MainMenu')->setActive(USER_MENU,'visit store');
        $this->layout = 'main';
        $this->render('create', 'example');
    }

    /**
     * update a product info
     */
    public function actionUpdate($id) {
        if (isset($_POST['product'])) {
            $product = new Product();
            print_r($_POST['product']);
            $product->setData($_POST['product']);
            if ($product->changesThanOrigin()) {
                $oldProductInfo = new Product($_POST['product']['id']);
                if ($product->update()) {
                    if ($oldProductInfo->getVal('product_name') != $product->getVal('product_name')) {
                        //if the folder name is updated
                        $product->updatePicUrls();
                    }
                    echo 'update product basic info sucessfully <br/>';
                } else {
                    echo 'update product failed';
                }
            }
            if ($this->hasChanges($_FILES)) {
                $product->updatePictures($_FILES);
            }
        }
        if (!empty($id)) {
            $model = new Product();
            $model->get($id);
            $picture = new Pictures();
            $pictureUrls = Pictures::getProductPictures($id);
            CT::widgets('MainMenu')->setActive(USER_MENU,'visit store');
            $this->render('update', array(
                'model' => $model->getData(),
                'pictureUlrs' => $pictureUrls,
            ));
        } else {
            header("Location: http://irene.local/Category/");
        }
    }
    
    /**just for testing **/
    public function actionTest() {
        $product = new Product();
        $product->setVal('product_name', 'kamasutra $*#* rada zenga');
        echo $product->generateFolderName();
    }

    private function hasChanges($files) {
        foreach ($files as $file) {
            if (!empty($file['name'])) {
                return true;
            }
        }
        return false;
    }
}
