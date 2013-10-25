    <?php
    /**
     * examle controller to manage an example controller
     * 
     * @author alexhoang <alexhoang.htd@gmail.com>
     * @copyright &copy; 2013 Createve Team 
     */
    class exampleController extends CTController{
        
        public function actionIndex($param = 0) {
            echo 'I am the index action for example controller';
        }
        public function actionView($param){
            echo ' viewing product example id = '.$param;
        }

    }