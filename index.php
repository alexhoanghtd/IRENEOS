<?php
//this will call the base mvc model
$ct = dirname(__FILE__)."/mvcct/CT.php";
//call all the config for the CT application
$config = dirname(__FILE__)."/protected/config/main.php";

//define the path to the app code
define ('BASE_PATH',  dirname(__FILE__));



require_once($ct);

CT::run($config);