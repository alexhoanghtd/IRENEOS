<?php

/**
 * Controller that control collections in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CollectionController extends CTController {

    public function actionIndex() {
        $model = new Collection();
        $data = $model->getCollectionList();
        CT::widgets('MainMenu')->setActive(USER_MENU,'collections');
        $this->render('index', $data);
        exit;
    }

    public function actionView($id) {
        if (!empty($id)) {
            $model = new Collection();
            $data = $model->getCollectionProducts($id);
            CT::widgets('MainMenu')->setActive(USER_MENU,'collections');
            $this->render('view', $data);
        } else {
            header("Location: http://irene.local/Collection");
        }
    }

    public function actionCreate() {
        if (isset($_POST['collection'])) {
            $collection = $_POST['collection'];
            $model = new Collection();
            $model->setData($collection);

            if ($model->create()) {
                $collectionName = $model->getVal('name');
                echo 'Collection ' . $collectionName . ' created succesfuly! :)<br/>';
                $collectionID = $model->getCollectionIdByName($collectionName);
                //$folderName = $model->generateFolderName();
                $folderName = "collections";
                foreach (array_keys($_FILES) as $key) {
                    if ($_FILES[$key]['error'] == 0) {
                        //create a new picture model
                        $pic = new Pictures();
                        //set product_id for the pic
                        $pic->setVal('category_id', $collectionID);
                        //set the product name associated with the picture
                        $pic->setVal('name', $collectionName);
                        if (Pictures::uploadPicture($_FILES[$key], $folderName)) {
                            // Get extension of file upload
                            $info = new SplFileInfo($_FILES[$key]['name']);
                            $extension = $info->getExtension();
                            // Rename File upload followed by CollectionName
                            $oriName = BASE_PATH . "/images/" . $folderName . "/" . $_FILES[$key]['name'];
                            $newName = BASE_PATH . "/images/" . $folderName . "/" . $collectionName . "." . $extension;
                            rename($oriName, $newName);
                            // Set type for the pic
                            $pic->setVal('type', 1);
                            // Set url for the pic
                            $url = "/images/" . $folderName . "/" . $collectionName . "." . $extension;
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
        }
        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'collections');
        $this->layout = 'main';
        $this->render('create', 'example');
    }


    public function actionDelete() {
        if (isset($_POST['collection'])) {
            $model = new Collection();
            $model->deleteCollection($_POST['collection']['id']);
        }
        $this->layout = 'main';
        CT::widgets('MainMenu')->setActive(USER_MENU,'collections');
        $this->render('delete', 'data');
    }

    public function actionUpdate() {
        if (isset($_POST['collection'])) {
            $collection = $_POST['collection'];
            $model = new Collection();
            if ($model->updateCollection($data)) {
                echo 'Update successfully';
            } else {
                echo 'Can not execute';
            }
        }
        $this->layout = 'main';
        CT::widgets('MainMenu')->setActive(ADMIN_MENU,'collections');
        $this->render('update', 'data');
    }
    
    public function actionProducts(){
        $this->render('products', '');
    }
}
