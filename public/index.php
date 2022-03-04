<?php
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

$config = require '../app/config.php';

$app = new \Slim\App(['settings' => $config]);
require '../app/dependencies.php';
require '../app/routes.php';
$app->run();
