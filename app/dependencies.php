<?php

$container = $app->getContainer();
$container['my_service'] = function($c){
    return 'My service';
};

$container['view'] =  new \Slim\Views\PhpRenderer('../app/views/',[
    'baseUrl' => 'http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/'
]);
