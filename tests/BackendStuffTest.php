<?php

class BackendStuffTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp(): void
    {
        $this->setBrowserUrl('http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]);
    }
}
