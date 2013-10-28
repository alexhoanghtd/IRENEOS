<?php
/**
 * Base Controller class
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 25 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CTController{
    /**
     * the default layout of the Controller
     * @var string
     */
    protected $layout = '';
    
    /**
     * Contructor of the base controller class
     */
    public function __construct() {
        $this->layout = ct::$_CONFIG['defaultLayout'];
    }
    
    /**
     * Default Index action ( page ) of any controller
     */
    function actionIndex(){
        echo 'this will be default index of the BASE Controller class';
    }

    /**
     * Load model with model name
     * @param String name of the model you want to load.
     */
    function loadModel($model){
       $path = BASE_PATH.'/protected/models/' . $model . '.php'; 
       if(file_exists($path)){
            require $path;
            return new $model();
        }else{
            Bootstrap::error('Can not load the model');
        }
    }
    
    /**
     * render the view accoridng ro action logic
     * @param array $data
     * @param string $view
     */
    static function renderError($errorString){
        //ERROR PREPARATION
        $errorView = new CTView();
        $errorView->data = $errorString;
        $errorView->layout = 'errorLayout';
        $errorView->viewBluePrint = 'error';
        $errorView->controllerName = 'site';
        
        //ERROR RENDER!
        $errorView->show();
    }
    function render($viewName,$data){
        /***RENDER PREPAREATION ***/
        // I need to create an View object which can show the content
        $view = new CTView();
        //set the layout for the view
        $view->layout = $this->layout;
        //set the blue print for the view of the view :P
        $view->viewBluePrint = $viewName;
        //set the controller name for the view
        $view->controllerName = str_replace("Controller", "", get_class($this));
        //set data for the view
        $view->data = $data;
        
        /**SHOW THE RESULT**/
        $view->show();
    }
}