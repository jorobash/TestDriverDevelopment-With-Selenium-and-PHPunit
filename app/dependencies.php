<?php

$container = $app->getContainer();
$container['my_service'] = function($c){
    return 'My service';
};

$container['view'] =  new \Slim\Views\PhpRenderer('../app/views/',[
    'baseUrl' => 'http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/'
]);

$container['db'] = function($container){
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal(); //allow static methods
    $capsule->bootEloquent(); // set up the Eloquent ORM

    return $capsule;
};
