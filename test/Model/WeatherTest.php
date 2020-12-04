<?php

namespace Gufo\Model;

use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherTest extends TestCase
{
    public function testConstructor()
    {

        $curl = new Curl();

        $res = new Weather(56.16156, 15.58661, $curl);

        $this->assertInstanceOf(Weather::class, $res);
    }

    public function testGetHistory()
    {
        $curl = new Curl();

        $weather = new Weather(56.16156, 15.58661, $curl);

        $res = $weather->getHistory();

        $this->assertInternalType("array", $res);
    }

    public function testGetForecast()
    {
        $curl = new Curl();

        $weather = new Weather(56.16156, 15.58661, $curl);

        $res = $weather->getForecast();

        $this->assertInternalType("array", $res);
    }

    public function testGetAll()
    {
        $curl = new Curl();

        $weather = new Weather(56.16156, 15.58661, $curl);

        $res = $weather->getAll();

        $this->assertInternalType("array", $res);
    }
}
