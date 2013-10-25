<?php
/*
*   with this class, we will analyze the request url and call
*   the acorrding M V C functions
*/
class Bootstrap{
    function __construct() {
        //get the url and break it to array of element
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        
        //echo $url[0];
        //In case the url array has only element equal to null
        
    }
}