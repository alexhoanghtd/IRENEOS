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
                print_r($_POST['collection']);
                $collectionName = $model->getVal('name');
                echo 'Collection ' . $collectionName . ' created succesfuly! :)<br/>';
                $collectionID = $model->getCollectionIdByName($collectionName);
                //$folderName = $model->generateFolderName();
                $folderName = "collection_cover";
                foreach (array_keys($_FILES) as $key) {
                    if ($_FILES[$key]['error'] == 0) {    
                        $pic = new Pictures();
                        $pic->setVal('collection_id', $collectionID);
                        $pic->setVal('name', $collectionName);
                        if (Pictures::uploadPicture($_FILES[$key], $folderName)) {
                            // Get extension of file upload
                            $info = new SplFileInfo($_FILES[$key]['name']);
                            $extension = $info->getExtension();
                            // Rename File upload followed by collectionName
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
            }else
            echo "Fail";
        }
        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'collections');
        $this->layout = 'main';
        $this->render('create', 'example');
    }


    public function actionDelete($id) {
        $collection = new Collection();
        $collection->deleteCollection($id);
        $collection->deleteFile($id);

        $pic = new Pictures();
        $pic->deletePicCollection($id);

        $this->layout = 'admin';
        $this->render('delete', $id);
    }

    public function actionUpdate($id) {
        if (isset($_POST['collection'])) {
            $collection = new Collection();
            $collection->setData($_POST['collection']);

            if (!isset($_POST['collection']['available'])) {
                $collection->setVal('available', '0');
            }
            if (!isset($_POST['collection']['is_new'])) {
                $collection->setVal('is_new', '0');
            }

            if ($collection->changesThanOrigin()) {
                $oldCollectionInfo = new Collection($_POST['collection']['id']);
                if ($collection->update()) {
                    if ($oldCollectionInfo->getVal('name') != $collection->getVal('name')) {
                        //if the collection name is updated

                        $folderName = "collection_cover";
                        foreach (array_keys($_FILES) as $key) {
                            Pictures::uploadPicture($_FILES[$key], $folderName);
                            $collection->updatePicUrls();
                        }
                    }
                    echo 'update collection basic info sucessfully <br/>';
                } else {
                    echo 'update collection failed';
                }
            } else {
                echo 'not changes than origin';
            }
            if ($this->hasChanges($_FILES)) {
                $collection->updatePictures($_FILES);
            }
        }
        if (!empty($id)) {
            $model = new Collection();
            $model->get($id);
            $picture = new Pictures();
            $pictureUrls = Pictures::getCollectionPictures($id);
            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'collections');
            $this->layout = 'main';
            $this->render('update', array(
                'model' => $model->getData(),
                'pictureUrls' => $pictureUrls,
            ));
        } else {
            header("Location: http://irene.local/collection/");
        }
    }

    public function actionList() {
        $collection = new collection();
        $pic = new Pictures();

        // Delete collection selected in checkbox
        if (isset($_POST['cbDelete'])) {
            foreach ($_POST['cbDelete'] as $id) {
                $collection->deleteCollection($id);
                $collection->deleteFile($id);
                $pic->deletePicture($id);
            }
        }

        // Quick active
        if (isset($_POST['collection'])) {
            foreach ($_POST['collection'] as $id) {
                if (!isset($_POST['cbActive'][$id])) {
                    $c = new collection($id);
                    $c->setVal('available', '0');
                    $c->update();
                } else {
                    $c = new collection($id);
                    $c->setVal('available', '1');
                    $c->update();
                }
            }
        }
        $data = $collection->getCollectionList();

        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'collections');
        $this->render('list', $data);
        exit;
    }

    
    public function actionProducts($id){
        $collection = new Collection();
        $pic = new Pictures();
        $this->render('products', '');
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

