<?php

namespace Gufo\Model;

use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class CurlTest extends TestCase
{
    public function testMCurl()
    {
        $curl = new Curl();

        $res = $curl->mcurl([
            "https://cat-fact.herokuapp.com/facts",
            "https://cat-fact.herokuapp.com/facts"
        ]);

        $this->assertInstanceOf(Curl::class, $curl);
        $this->assertIsArray($res);
    }
}
