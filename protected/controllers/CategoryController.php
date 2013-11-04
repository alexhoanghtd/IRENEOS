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
        $model = new Category();
        $data = $model->getCategoryList();
        //print_r($data);
        $this->render('index', $data);
        //header("Location: http://irene.local/");
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    }

    /**
     * show the product with id = $id
     * @param int $id of the category
     */
    function actionView($id) {
        //load data for category which will be shown
        if (!empty($id)) {
            $model = new Category();
            $data = $model->getCategoryProducts($id);
            CT::widgets('MainMenu')->setActive('visit store');
            $this->render('view', $data);
        } else {
            header("Location: http://irene.local/Category");
        }
    }

    public function actionDelete() {
        if (isset($_POST['category'])) {
            $model = new Category();
            $model->deleteCategory($_POST['category']['id']);
        }
        $this->layout = 'admin';
        $this->render('delete', 'example');
    }

    public function actionCreate() {
        if (isset($_POST['category'])) {
            $category = $_POST['category'];
            $model = new Category();
            $model->setData($category);
            
            if ($model->create()) {
                $categoryName = $model->getVal('name');
                echo 'Category ' . $categoryName . ' created succesfuly! :)<br/>';
                $categoryID = $model->getCategoryIdByName($categoryName);
                $folderName = $model->generateFolderName();
                //create a folder acording to the product name
                if (Pictures::createPictureFoler($folderName)) {
                    //if create folder sucessfully
                    foreach (array_keys($_FILES) as $key) {
                        if ($_FILES[$key]['error'] == 0) {
                            //create a new picture model 
                            $pic = new Pictures();
                            //set product_id for the pic
                            $pic->setVal('category_id', $categoryID);
                            //set the product name associated with the picture
                            $pic->setVal('name', $categoryName);
                            if ($url = Pictures::uploadPicture($_FILES[$key], $folderName)) {
                                $pic->setVal('type', 1);
                                $pic->setVal('url', $url);
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
        $this->layout = 'main';
        $this->render('create','example');
    }

    public function actionUpdate() {
        if (isset($_POST['category'])) {
            $category = $_POST['category'];
            $model = new Category();
            if ($model->updateCategory($category)) {
                echo 'Category updated succesfuly! :)<br/>';
            } else {
                echo "Failed!!!";
            }
        }
        $this->layout = 'main';
        $this->render('update', 'example');
    }

}
