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
            CT::widgets('MainMenu')->setActive('collections');
            $this->render('view', $data);
        } else {
            header("Location: http://irene.local/Collection");
        }
    }

    public function actionDelete() {
        if (isset($_POST['collection'])) {
            $model = new Collection();
            $model->deleteCollection($_POST['collection']['id']);
        }
        $this->layout = 'main';
        CT::widgets('MainMenu')->setActive('collections');
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
    
    public function actionProduct(){
        $this->render('products', '');
    }
}
