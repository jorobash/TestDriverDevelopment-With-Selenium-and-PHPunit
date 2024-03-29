<?php

use App\Models\Category;

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
            $table->text('description')->nullable(false);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
//        $capsule::table('categories')->insert(
//            ['name' => 'Electronics']
//        );

//        Category::create([
//            'name' => 'Electronics',
//            'description' => 'Descrption of electronics'
//        ]);
    }

    public function setUp(): void
    {
        $this->setBrowserUrl('http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]);
    }

    public function testCanSeeAddedCategories()
    {

        Category::create([
            'name'=>'Electronics',
            'description'=>'Description of Electronics',
        ]);

        $this->url('');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/[0-9]+,Electronics@',$href);

        $this->url('show-category/1');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/[0-9]+,Electronics@',$href);

    }

    public function testCanAddChildCategory()
    {
        $electronics = Category::where('name','Electronics')->first();
        $electronics->children()->saveMany([
            new Category(['name'=>'Monitors','description'=>'Description of Monitors']),
            new Category(['name'=>'Tablets','description'=>'Description of Tablets']),
            new Category(['name'=>'Computers','description'=>'Description of Computers']),
        ]);

        $computers = Category::where('name','Computers')->first();
        $computers->children()->saveMany([
            new Category(['name'=>'Desktops','description'=>'Description of Desktops']),
            new Category(['name'=>'Notebooks','description'=>'Description of Notebooks']),
            new Category(['name'=>'Laptops','description'=>'Description of Laptops']),
        ]);

        $laptops = Category::where('name','Laptops')->first();
        $laptops->children()->saveMany([
            new Category(['name'=>'Asus','description'=>'Description of Asus']),
            new Category(['name'=>'Dell','description'=>'Description of Dell']),
            new Category(['name'=>'Acer','description'=>'Description of Acer']),
        ]);

        $acer = Category::where('name','Acer')->first();
        $acer->children()->saveMany([
            new Category(['name'=>'FullHD','description'=>'Description of FullHD']),
            new Category(['name'=>'HD+','description'=>'Description of HD+'])
        ]);

        Category::create([
            'name'=>'Videos',
            'description'=>'Description of Videos',
        ]);
        Category::create([
            'name'=>'Software',
            'description'=>'Description of Software',
        ]);

        $software = Category::where('name','Software')->first();
        $software->children()->saveMany([
            new Category(['name'=>'Operating systems','description'=>'Description of Operating systems']),
            new Category(['name'=>'Servers','description'=>'Description of Servers'])
        ]);

        $operating_systems = Category::where('name','Operating systems')->first();
        $operating_systems->children()->saveMany([
            new Category(['name'=>'Linux','description'=>'Description of Linux'])
        ]);

        $this->url('');

        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/[0-9]+,Monitors@',$href);
    }

    public function testCanSeePopulatedFromDataWhenCategoryIsEdited()
    {
        $this->url('edit-category/17');
        $category_name = $this->byName('category_name');
        $name = $category_name->value();
        $this->assertSame('Linux', $name);

        $category_description = $this->byName('category_description');
        $description = $category_description->value();
        $this->assertSame('Description of Linux',$description);
    }

    public function testCanSeeCorrectParentCategoryWhenEditedChildCategory()
    {
        $this->url('edit-category/17');
        $this->assertSame('15',$this->select(
            $this->byId('select_category_list'))->selectedValue()
        );
    }

    public function testCanSeeCategoryIdToBeEdited()
    {
        $this->url('edit-category/17');
        $this->assertContains('input type="hidden" name="category_id"',$this->source());

        $this->url('show-category/17,Linux');
        $this->assertNotContains('input type="hidden" name="category_id"',$this->source());
    }

    public function testCanEditCategory()
    {
        $this->url('edit-category/17');

        $categoryName = $this->byName('category_name');
        $categoryName->clear();
        $categoryName->value('Windows');
        $categoryDescription = $this->byName('category_description');
        $categoryDescription->clear();
        $categoryDescription->value('Description of Windows');

        $this->select($this->byId('select_category_list'))->selectOptionByValue("16");

        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();

        $this->url('');

        $this->assertNotContains('Linux',$this->source());

        $this->url('edit-category/17');

        $categoryName = $this->byName('category_name');
        $categoryName->clear();
        $categoryName->value('Linux');
        $categoryDescription = $this->byName('category_description');
        $categoryDescription->clear();
        $categoryDescription->value('Description of Linux');

        $this->select($this->byId('select_category_list'))->selectOptionByValue("15");

        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
    }

    public function testCanAddCategory()
    {
        $this->url('');

        $categoryName = $this->byName('category_name');
        $categoryName->value('Windows');
        $categoryDescription = $this->byName('category_description');
        $categoryDescription->value('Description of Windows');

        $this->select($this->byId('select_category_list'))->selectOptionByValue('15');
        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();

        $this->url('show-category/18,Windows');
        $this->assertContains('Description of Windows',$this->source());
    }
}
