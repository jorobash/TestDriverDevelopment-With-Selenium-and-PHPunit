<?php

class FrontendStuffTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp()
    {
        $this->setBrowserUrl('http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' =>
            ['w3c' => false]]);
    }

    public function testCanSeeCorrectStringsOnMainPage()
    {
        $this->url('');
        $this->assertContains('Add a new category',$this->source());
    }

    public function testCanSeeConfirmDialogBoxWhenTryingToDeleteCategory()
    {
        $this->url('show-category/1');
        $this->clickOnElement('delete-category-confirmation');
        $this->waitUntil(function(){
            if($this->alertIsPresent()) return true;
            return null;
        },4000);
        $this->dismissAlert();
        $this->assertTrue(true);
    }

    public function testCanSeeEditAndDeleteLinksAndCategoryName()
    {
        $this->url('show-category/1');
        $electronics = $this->byLinkText('Electronics');
        $electronics->click();
        $h5 = $this->byCssSelector('div.basic-card-content h5');
        $this->assertContains('Electronics',$h5->text());

        $editLink = $this->byLinkText('Edit');
        $href = $editLink->attribute('href');
        $this->assertContains('edit-category/1',$href);
        $this->assertContains('Description of Electronics',$this->source());
    }

    public function testSeeEditCategoryMessage()
    {
        $this->url('show-category/1');
        $editLink = $this->byLinkText('Edit');
        $editLink->click();
        $this->assertContains('Edit category',$this->source());
    }

    public function testCanSeeFormValidation()
    {
        $this->url('');
        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
        $this->assertContains('Fill correctly the form',$this->source());

        $this->back();
        $categoryName = $this->byName('category_name');
        $categoryName->value("Joro");
        $categoryDescription = $this->byName('category_description');
        $categoryDescription->value('Description text');
        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
        $this->assertContains('Category was saved',$this->source());
    }

    public function testCanSeeNestedCategories()
    {
        $this->url('');
        $categories = $this->elements(
            $this->using('css selector')
                ->value('ul.dropdown li'));
        $this->assertEquals(18,count($categories));

        $element2 = $this->byCssSelector('ul.dropdown > li:nth-child(2) > a');
        $this->assertEquals('Electronics',$element2->text());

        $element3 = $this->byCssSelector('ul.dropdown > li:nth-child(3) > a');
        $this->assertEquals('Videos',$element3->text());

        $element4 = $this->byCssSelector('ul.dropdown > li:nth-child(4) > a');
        $this->assertEquals('Software',$element4->text());

//        $element5 = $this->byCssSelector('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a' );
//        $text = $element5->attribute('text');

          $element5 = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
          $text = $element5->attribute('text');
          $href = $element5->attribute('href');
          $this->assertRegExp('@^http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/[0-9]+,Monitors$@',$href);

          $element6 = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]//ul[1]//ul[1]//ul[1]/li[1]/a');
          $href = $element6->attribute('href');
          $this->assertRegExp(
              '@^http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/[0-9]+,FullHD$@',$href
          );
    }

    public function testCanSeeCorrectMessageAfterDeletingCategory()
    {
        $this->url('show-category/1');
        $this->clickOnElement('delete-category-confirmation');
        $this->waitUntil(function(){
            if($this->alertIsPresent()) return true;
            return null;
        },4000);
        $this->acceptAlert();
        $this->assertContains('Category was deleted',$this->source());

        $this->url('');
        $this->assertNotRegExp('@Computers</a>@',$this->source());
    }

    public function testCanSeePopulatedFormDataWhenCategoryIsEdited()
    {
        $this->url('edit-category/17');
        $categoryName = $this->byName('category_name');
        $name = $categoryName->value();
        $this->assertSame('Linux',$name);

        $categoryDescription = $this->byName('category_description');
        $description = $categoryDescription->value();
        $this->assertSame('Description of Linux',$description);
    }
}
