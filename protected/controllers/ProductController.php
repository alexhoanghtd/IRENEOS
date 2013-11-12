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
            Product::updateProduct($_POST['product']);
        }
        if (!empty($id)) {
            $checkProduct = new Product();
            $checkProduct->setVal('id', $id);
            if ($checkProduct->checkExists()) {
                $categoryID = CategoryProduct::getProductCategory($id);
                $model = new Product($id);
                $picture = new Pictures();
                $pictureUrls = Pictures::getProductPictures($id);
                CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'products');
                $this->render('update', array(
                    'model' => $model->getData(),
                    'pictureUlrs' => $pictureUrls,
                    'categoryID' => $categoryID,
                    'attributes' => $model->getProductAttributes(),
                    'colors' => Color::getAll(),
                    'sizes' => Size::getAll(),
                ));
            } else {
                echo "product doesn't exist";
                //$this->renderError("product Id Doesn't exist'");
            }
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    public function actionUpdatePictures($productID) {
        $product = new Product($productID);
        $product->updatePictures($_FILES);
        CT::redirect_to(CT::baseURL() . '/product/Update/' . $productID);
    }

    public function actionDelete($id) {
        Product::deleteProduct($id);
    }

    /*     * just for testing * */

    public function actionTest() {
        $product = new Product();
        $product->setVal('product_name', 'kamasutra $*#* rada zenga');
        echo $product->generateFolderName();
    }

    public function actionAjaxSearch() {
        //print_r($_POST);
        if (isset($_POST['name'])) {
            $products = Vproduct::search($_POST['name']);
            $this->renderAjax('_userSearch', $products);
        }
    }

    public function actionList($page) {
        if (!empty($page)) {
            $product = new Product();

            // Delete category selected in checkbox
            if (isset($_POST['checkbox'])) {
                foreach ($_POST['checkbox'] as $id) {
                    $p = new Product($id);
                    $p->delete();
                }
            }

            // Quick active    
            if (isset($_POST['product'])) {
                foreach ($_POST['product'] as $id) {
                    if (!isset($_POST['cbActive'][$id])) {
                        $p = new Product($id);
                        $p->setVal('available', '0');
                        $p->update();
                    } else {
                        $p = new Product($id);
                        $p->setVal('available', '1');
                        $p->update();
                    }
                }
            }

            $data = $product->getProductList($page);

            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'categories');
            $this->render('list', $data);
        } else {
            header("Location: http://irene.local/Product/List/1");
        }
    }

}
