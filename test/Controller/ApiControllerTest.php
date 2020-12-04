<?php

namespace Gufo\Controller;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;
use Anax\DI\DIMagic;

/**
 * Test the SampleController.
 */
class ApiControllerTest extends TestCase
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
        $this->controller = new ApiController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testIpActionPostNoAddress()
    {
        $res = $this->controller->ipActionPost();

        $this->assertEquals($res[0]['message'], "no ip address specified.");
    }

    public function testIpActionPostAddress()
    {
        $this->di->request->setPost('address', '194.47.150.9');

        $res = $this->controller->ipActionPost();

        $this->assertInternalType("array", $res);
    }

    public function testWeatherActionGetNoAddress()
    {
        $res = $this->controller->weatherActionGet();

        $this->assertEquals($res[0]['message'], "no ip address specified.");
    }

    public function testWeatherActionGetValidAddress()
    {
        $this->di->request->setGet('ipAddress', '194.47.150.9');

        $res = $this->controller->weatherActionGet();

        $this->assertInternalType("array", $res);
    }

    public function testWeatherActionGetInvalidAddress()
    {
        $this->di->request->setGet('ipAddress', 'dsadsadsa');

        $res = $this->controller->weatherActionGet();

        $this->assertEquals($res[0]['message'], "not a valid ip address.");
    }

    public function testWeatherActionGetLocalAddress()
    {
        $this->di->request->setGet('ipAddress', '127.0.0.1');

        $res = $this->controller->weatherActionGet();

        $this->assertEquals($res[0]['message'], "You have provided a valid ip address, but weather/locational data can not be extracted from it.");
    }
}
