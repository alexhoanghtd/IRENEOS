<?php
/**
 * Base View class
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CTView{
    
    public $layout;
    public $viewBluePrint;
    public $controllerName;
    public $data;
    
    public function __construct() {
        $this->layout = CT::$_CONFIG['defaultLayout'];
        $this->viewBluePrint = 'index';
        $this->data = "DEFAULT DATA";
        $this->controllerName = CT::$_CONFIG['defaultController'];
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