<?php

/**
 * with this class, we will analyze the request url
 *  and call the acorrding M V C functions
 * 
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @copyright &copy; 2013 Creative Team 
 */
class Bootstrap {

    //stored analyzed url
    private $urlArr = array(
        "controller" => null,
        "action" => null,
        "param" => null,
        "trash" => null,
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

    private function startMVC() {
        //if controllerName is set then check if that controller with this name
        //exists
        //echo $this->urlArr['controller'];
        if ($this->urlArr['trash'] != null) {
            $this->error('404');
            return;
        }
        if ($this->urlArr['controller'] != null) {
            //if it controller name is set, try to instanitiate the controller
            //object, if not exist controller, return false
            $controller = $this->requestController($this->urlArr['controller']);
            if (!$controller) {
                $this->error("controller doesn't exist");
            } else {
                if (CT::user()->isAllowed($controller)) {
                    //if the controller exist,start checking action
                    $action = $this->urlArr['action'];
                    if ($action != null) {
                        //if the url has the part for action
                        //Need to get the list of that controller action and check
                        //if the action exist 

                        if ($this->isMethodExist($controller, $action)) {
                            //action of class exist
                            $actionMethod = 'action' . $action;
                            if (CT::user()->isAllowed($controller, $action)) {
                                $controller->{$actionMethod}($this->urlArr['param']);
                            } else {
                                echo 'you are not authorized for this action';
                            }
                        } else {
                            //Call controler's default's action with param as 
                            //recieved action name
                            $this->error("action doesn't exist'");
                        }
                    } else {//if action is not set
                        if (CT::user()->isAllowed($controller, 'Index')) {
                            $controller->actionIndex();
                        } else {
                            echo 'you are not authorized to access this action!';
                        }
                    }
                } else {
                    echo 'You are not authorized for this controller';
                }
            }
        } else {
            $controllerName = ct::$_CONFIG['defaultController'];
            //if controller name is not set
            require BASE_PATH . '/protected/controllers/' . $controllerName . 'Controller.php';
            //instanitiate default controler with defaul action
            $controllerClass = $controllerName . "Controller";
            $controller = new $controllerClass;
            $controller->actionIndex();
        }
    }

    /*     * ***Helper Functions**** */

    /*
     * include controller class file into the process flow
     * intanitiate the controller object
     * @return the controller object if created
     * @return false if can't create the object
     */

    private function requestController($controllerName) {
        $controlerFolder = '/protected/controllers/';
        $controllerFile = BASE_PATH . $controlerFolder . $controllerName . 'Controller.php';
        if (file_exists($controllerFile)) {
            require $controllerFile;
            //echo $controllerFile;
            $controllerClass = $controllerName . 'Controller';
            return new $controllerClass;
        } else {
            return false;
        }
    }

    /**
     * show if there is an error
     * @param show $errorString
     */
    static function error($errorString) {
        echo ':( SORRY!' . $errorString;
    }

    /**
     * check if the controller has the action
     */
    private function isMethodExist($controller, $action) {
        $actions = get_class_methods($controller);
        foreach ($actions as $actionItem) {
            if ('action' . $action == $actionItem)
                return true;
        }
        //print_r($actions);
        return false;
    }

    /**
     *  Analyse the url into part
     */
    private function analyzeURL() {
        //get the url and break it to array of element
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        //print_r($url);
        $this->urlArr = array(
            "controller" => isset($url[0]) ? $url[0] : null,
            "action" => isset($url[1]) ? $url[1] : null,
            "param" => isset($url[2]) ? $url[2] : null,
            "trash" => isset($url[3]) ? $url[3] : null,
        );
    }

}
