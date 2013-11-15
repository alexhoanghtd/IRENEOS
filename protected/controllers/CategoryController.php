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
        CT::widgets('MainMenu')->setActive(USER_MENU, 'visit store');
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
            CT::widgets('MainMenu')->setActive(USER_MENU, 'visit store');
            $this->render('view', $data);
        } else {
            header("Location: http://irene.local/Category");
        }
    }

    // Delete Category
    public function actionDelete($id) {
        $category = new Category();
        $category->deleteCategory($id);
        $category->deleteFile($id);

        $pic = new Pictures();
        $pic->deletePicture($id);

        $this->layout = 'admin';
        $this->render('delete', $id);
    }

    // Create Category
    public function actionCreate() {
        if (isset($_POST['category'])) {
            $category = $_POST['category'];
            $model = new Category();
            $model->setData($category);

            if ($model->create()) {
                $categoryName = $model->getVal('name');
                echo 'Category ' . $categoryName . ' created succesfuly! :)<br/>';
                $categoryID = $model->getCategoryIdByName($categoryName);
                //$folderName = $model->generateFolderName();
                $folderName = "categories";
                foreach (array_keys($_FILES) as $key) {
                    if ($_FILES[$key]['error'] == 0) {
                        //create a new picture model 
                        $pic = new Pictures();
                        //set product_id for the pic
                        $pic->setVal('category_id', $categoryID);
                        //set the product name associated with the picture
                        $pic->setVal('name', $categoryName);
                        if (Pictures::uploadPicture($_FILES[$key], $folderName)) {
                            // Get extension of file upload
                            $info = new SplFileInfo($_FILES[$key]['name']);
                            $extension = $info->getExtension();
                            // Rename File upload followed by CategoryName
                            $oriName = BASE_PATH . "/images/" . $folderName . "/" . $_FILES[$key]['name'];
                            $newName = BASE_PATH . "/images/" . $folderName . "/" . $categoryName . "." . $extension;
                            rename($oriName, $newName);
                            // Set type for the pic
                            $pic->setVal('type', 1);
                            // Set url for the pic
                            $url = "/images/" . $folderName . "/" . $categoryName . "." . $extension;
                            $pic->setVal('url', $url);
                            if ($pic->create()) {
                                echo 'save picture sucessfully <br/>';
                            } else {
                                echo 'save picture failed <br/>';
                            }
                        } else {
                            echo 'failed to upload the picture';
                        }
                    } else {
                        echo 'picture has error';
                    }
                }
            }
            header("location: ../../Category/List");
        }
        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'categories');
        $this->layout = 'main';
        $this->render('create', 'example');
        
    }

    public function actionUpdate($id) {
        if (isset($_POST['category'])) {
            $category = new Category();
            print_r($_POST['category']);
            $category->setData($_POST['category']);

            if (!isset($_POST['category']['available'])) {
                $category->setVal('available', '0');
            }
            if (!isset($_POST['category']['is_new'])) {
                $category->setVal('is_new', '0');
            }

            if ($category->changesThanOrigin()) {
                $oldCategoryInfo = new Category($_POST['category']['id']);
                if ($category->update()) {
                    if ($oldCategoryInfo->getVal('name') != $category->getVal('name')) {
                        //if the category name is updated

                        $folderName = "categories";
                        foreach (array_keys($_FILES) as $key) {
                            Pictures::uploadPicture($_FILES[$key], $folderName);
                            $category->updatePicUrls();
                        }
                    }
                    echo 'update category basic info sucessfully <br/>';
                } else {
                    echo 'update category failed';
                }
            } else {
                echo 'not changes than origin';
            }
            if ($this->hasChanges($_FILES)) {
                $category->updatePictures($_FILES);
            }
        }
        if (!empty($id)) {
            $model = new Category();
            $model->get($id);
            $picture = new Pictures();
            $pictureUrls = Pictures::getCategoryPictures($id);
            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'categories');
            $this->layout = 'main';
            $this->render('update', array(
                'model' => $model->getData(),
                'pictureUrls' => $pictureUrls,
            ));
        } else {
            header("Location: http://irene.local/Category/");
        }
    }

    private function hasChanges($files) {
        foreach ($files as $file) {
            if (!empty($file['name'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function actionList() {
        $category = new Category();
        $pic = new Pictures();

        // Delete category selected in checkbox
        if (isset($_POST['cbDelete'])) {
            foreach ($_POST['cbDelete'] as $id) {
                $category->deleteCategory($id);
                $category->deleteFile($id);
                $pic->deletePicture($id);
            }
        }

        // Quick active    
        if (isset($_POST['category'])) {
            foreach ($_POST['category'] as $id) {
                if (!isset($_POST['cbActive'][$id])) {
                    $c = new Category($id);
                    $c->setVal('available', '0');
                    $c->update();
                } else {
                    $c = new Category($id);
                    $c->setVal('available', '1');
                    $c->update();
                }
            }
        }
        $data = $category->getCategoryList();

        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'categories');
        $this->render('list', $data);
        //header("Location: http://irene.local/");
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    }

}
