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

            if ($id = $model->create()) {
                $newCollection = new Collection($id);
                $folderName = $newCollection->generateFolderName();
                echo $folderName;
                foreach (array_keys($_FILES) as $key) {
                    if ($_FILES[$key]['error'] == 0) {    
                        $pic = new Pictures();
                        $pic->setVal('collection_id', $id);
                        $pic->setVal('name', $newCollection->getVal('name'));
                        if ($url = Pictures::uploadPicture($_FILES[$key], $folderName)) {
                            // Set type for the pic
                            $pic->setVal('type', COLLECTION_COVER);
                            // Set url for the pic
                            $pic->setVal('url', $url);
                            if ($pic->create()) {   
                                echo 'save picture sucessfully <br/>';
                            } else {
                                echo 'save picture failed <br/>';
                            }
                        } else {
                            echo "failed to upload the picture $url";
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
        $collection = new Collection($id);
        $pic = new Pictures();
        $this->render('products', array(
            "collectionData" => $collection->getData(),
            "pictureModels" => '',
        ));
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

