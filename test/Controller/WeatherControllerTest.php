<?php

namespace Gufo\Controller;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;
use Anax\DI\DIMagic;

/**
 * Test the SampleController.
 */
class WeatherControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIMagic();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testWeatherActionGetNoAddress()
    {
        $res = $this->controller->IndexActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testWeatherActionGetWithValidAddress()
    {
        $this->di->request->setGet('ipAddress', '194.47.150.9');

        $res = $this->controller->IndexActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testWeatherActionGetWithLocalAddress()
    {
        $this->di->request->setGet('ipAddress', '127.0.0.1');

        $res = $this->controller->IndexActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testWeatherActionGetWithInvalidAddress()
    {
        $this->di->request->setGet('ipAddress', 'dsadsad');

        $res = $this->controller->IndexActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
