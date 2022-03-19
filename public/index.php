<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

$config = require '../app/config.php';

$app = new \Slim\App(['settings' => $config]);
require '../app/dependencies.php';
require '../app/bootstrap.php';
require '../app/routes.php';
$app->run();
