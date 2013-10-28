<?php
//return an array hold the main configuration for the application
return array(
    'db' => array(
        'connectionString' => '/protected/data/ICOS.db',
        'tablePrefix' => 'ic_',
    ),  
    'defaultController' => 'Site',
    'defaultLayout'=>'main',
    'widgets'=> array(
        'MainMenu' => array(
            'new arrivals' => ct::baseURL(),
            'collections' => '/Collection/',
            'about us' => '/Site/About/',
            'contact us' => '/Site/Contact',
            'visit store' => '/Category/',
            'bag' => '/bag/',
         )
    ),
);

