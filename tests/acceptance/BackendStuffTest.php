<?php

class BackendStuffTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public static function setUpBeforeClass(): void
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

        $capsule::schema()->dropIfExists('categories');

        $capsule::schema()->create('categories', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->bigInteger('parent_id')->unsigned()->nullable();
        });
        $capsule::table('categories')->insert(
            ['name' => 'Electronics']
        );
    }

    public function setUp(): void
    {
        $this->setBrowserUrl('http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]);
    }

    public function testCanSeeCorrectStringsOnMainPage()
    {
        $this->url('');
        $this->assertContains('Electronics',$this->source());
    }
}
