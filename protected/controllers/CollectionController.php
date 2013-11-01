<?php

/**
 * Controller that control collections in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CollectionController extends CTController {

    public function actionIndex($param = 0) {
        CT::widgets('MainMenu')->setActive('collections');
        $this->render('index', 'data');
    }

    public function actionView($id) {
        if (!empty($id)) {
            $model = new Collection();
            $data = $model->getCollection($id);
            CT::widgets('MainMenu')->setActive('collections');
            $this->render('view', $data);
        } else {
            header("Location: http://irene.local/");
        }
    }

}
