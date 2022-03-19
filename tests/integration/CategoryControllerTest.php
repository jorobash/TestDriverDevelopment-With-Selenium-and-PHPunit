<?php


use App\Controllers\CategoryController;
use Slim\Container;
use App\Services\CategoriesFactory;

class CategoryControllerTest extends \PHPUnit\Framework\TestCase
{
    public static $controller;

    public static function setUpBeforeClass()
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
        $container = new Container;
        $container['view'] = new \Slim\Views\PhpRenderer('./app/views/',[
            'baseUrl' => 'http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/'
        ]);
        $categories = CategoriesFactory::create();
        $container->view->addAttribute('categories',$categories['menu_categories']);
        $container->view->addAttribute('select_list_categories',$categories['select_list_categories']);
        self::$controller = new CategoryController($container);
    }

    public function testCanSeeEditedVideosCategory()
    {
        $environment = \Slim\Http\Environment::mock([
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/show-category/13,Videos',
                'QUERY_STRING'=>'']
        );
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $response = new \Slim\Http\Response();
        $response = self::$controller->showCategory($request, $response, ['id'=>13]);
        $this->assertContains('Description of Videos', (string) $response->getBody());
    }

}
