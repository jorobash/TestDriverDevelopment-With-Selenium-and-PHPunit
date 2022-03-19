<?php

use App\Models\Category;
use App\Services\CategoriesFactory;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal(); //allow static methods
$capsule->bootEloquent(); // set up the Eloquent ORM

$categories = CategoriesFactory::create();
$container->view->addAttribute('categories',$categories['menu_categories']);
$container->view->addAttribute('select_list_categories',$categories['select_list_categories']);
