<?php
/*
*   with this class, we will analyze the request url and call
*   the acorrding M V C functions
*/
class Bootstrap{
    //stored analyzed url
    private $urlArr = array(
         "controller" =>  "",
            "action" => "",
            "parameter"=> "",
            "parameterAction" => "",
    );
    function __construct() {

        //break the url into private urlArr attribute
        $this->analyzeURL();
        
        //apply the rule to call MVC class with defined rules
        $this->startMVC();
    }
    /*
     * appying url rule to MVC MODEL
     */
    private function startMVC(){
        //if controllerName is set then check if that controller with this name
        //exists
        if(isset($this->urlArr['controller'])){
            //if it controller name is set, try to instanitiate the controller
            //object, if not exist controller, return false
            $controller = $this->requestController($this->urlArr['controller']);
            //if doesn't exist
            if(!$controller){
                $this->error(" controller doesn't exist");
            }else{
                //if the controller exist,start checking action
                if(isset($this->urlArr['action'])){
                    //if the url has the part for action
                    
                }else{
                    //if action is not set
                    $controller->actionIndex();
                }
            }
        }else{
            //if controller name is not set
            
            //instanitiate default controler with defaul action
            $controller = new ct::$_CONFIG['defaultController'];
            $controller->actionIndex();
        }
    }
    
    /*****Helper Functions*****/
    
    /*
     * include controller class file into the process flow
     * intanitiate the controller object
     * @return the controller object if created
     * @return false if can't create the object
     */
    function requestController($controllerName){
        $controlerFolder = '/protected/controllers/';
        $controllerFile = BASE_PATH.$controlerFolder.$controllerName.'Controller.php';
        if(file_exists($controllerFile)){
            require BASE_PATH.$controlerFolder.$controllerName.'Controller.php';
            return new $controllerName;
        }else{
            return false;
        }
    }
    
    function error($errorString){
        echo ':( SORRY!'.$errorString;
    }
    
    /*
     *  Analyse the url into part
     */
    private function analyzeURL(){
        //get the url and break it to array of element
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        $this->urlArr = array(
            "controller" => isset($url[0]) ? $url[0] : null,
            "action" => isset($url[1]) ? $url[1] : null,
            "parameter"=> isset($url[2]) ? $url[2] : null,
            "parameterAction" => isset($url[3]) ? $url[3] : null,
        );
    }
}