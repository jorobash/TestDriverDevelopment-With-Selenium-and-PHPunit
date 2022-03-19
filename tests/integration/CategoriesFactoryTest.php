<?php

use App\Services\CategoriesFactory;

class CategoriesFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanProduceStringBasedOnArray()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => '127.0.0.1',
//            'database' => '/opt/lampp/htdocs/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/app/database/db.sqlite',
            'database' => 'TestDriverDevelpmentSelenium',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]);
        $capsule->setAsGlobal(); // allow static methods
        $capsule->bootEloquent(); // setup the Eloquent ORM
        $this->assertTrue(is_string(CategoriesFactory::create()['menu_categories']));
        $this->assertTrue(is_array(CategoriesFactory::create()['select_list_categories']));
    }
}
