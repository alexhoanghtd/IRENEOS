<?php

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
     * Loat model with model name
     * @param String name of the model you want to load.
     */
    function loadModel($model){
        $path = BASE_PATH.'models/' . $model . '.php'; 
       if(file_exists($path)){
            require $path;
            $this->model = new $model();
        }else{
            Bootstrap::error();
        }
    }
    
    /**
     * render the view accoridng ro action logic
     * @param array $data
     * @param string $view
     */
    function render($data,$viewName){
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

/**
 * this class represent a completed view file that can show to the user
 * 
 */
class CTView{
    
    public $layout;
    public $viewBluePrint;
    public $controllerName;
    public $data;
    
    public function __construct() {
        $this->layout = ct::$_CONFIG['defaultLayout'];
        $this->viewBluePrint = 'index';
        $this->data = "DEFAULT DATA";
        $this->controllerName = ct::$_CONFIG['defaultController'];
    }
    
    /**
     * Content data at the end is a HTML file that show fully styled information
     * but only the part of the things
     * 
     * @param mixed $data data that you need to display
     * @param string $view name of the view blue print that use $data as the 
     * information needed to display
     */
    private function renderContent($data,$view){
        //execute the php content and return it as string, then you can echo it later
        ob_start();
        //get the php view file path
        $viewPath = BASE_PATH.'/protected/views/'.$this->controllerName.'/'.$view.'.php';
        include($viewPath);
        $returned = ob_get_contents();
        ob_end_clean();
        return $returned;
    }
    /**
     * this will put the content into the layout
     */
    private function buildView($content){
        require BASE_PATH.'/protected/views/layouts/'.$this->layout.'.php';
    }
    
    /**
     * Show time :D everthing you prepared will be show here!
     */
    public function show(){
        //render the content part
        $content = $this->renderContent($this->data, $this->viewBluePrint);
        $this->buildView($content);
    }

}