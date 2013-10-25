<?php
//return an array hold the main configuration for the application
return array(
    'db' => array(
        'connectionString' => 'sqlite:protected/data/ICOS.db',
        'tablePrefix' => 'ic_',
    ),  
    'defaultController' => 'site',
);

