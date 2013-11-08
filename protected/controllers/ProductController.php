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

    /* test */

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
            $id = Product::createProduct($_POST['product'], $_FILES);

            if ($id)
                CT::redirect_to(CT::baseURL() . '/product/Update/' . $id);
        }

        CT::widgets('MainMenu')->setActive(USER_MENU, 'visit store');
        $this->layout = 'main';
        $this->render('create', 'example');
    }

    /**
     * update a product info
     */
    public function actionUpdate($id) {
        if (isset($_POST['product'])) {
            $product = new Product();
            $product->setData($_POST['product']);
            if (isset($_POST['product']['categoryID'])) {
                if ($_POST['product']['categoryID'] > 0) {
                    $product->updateCategory($_POST['product']['categoryID']);
                }
            }
            //check if the new info is different than origin
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
            } else {
                echo "<br/>Basic info doesn't changes than origin";
            }
            if ($this->hasChanges($_FILES)) {
                $product->updatePictures($_FILES);
            }
        }
        if (!empty($id)) {
            $categoryID = CategoryProduct::getProductCategory($id);
            $model = new Product();
            $model->get($id);
            $picture = new Pictures();
            $pictureUrls = Pictures::getProductPictures($id);
            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'products');
            $this->render('update', array(
                'model' => $model->getData(),
                'pictureUlrs' => $pictureUrls,
                'categoryID' => $categoryID,
            ));
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    public function actionDelete($id) {
        $product = new Product($id);
        $product->delete();
    }

    /*     * just for testing * */

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

    public function actionAjaxSearch() {
        //print_r($_POST);
        if (isset($_POST['name'])) {
            $products = Vproduct::search($_POST['name']);
            $this->renderAjax('_userSearch', $products);
        }
    }

}
