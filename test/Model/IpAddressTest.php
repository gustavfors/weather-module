<?php

namespace Gufo\Model;

use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpAddressTest extends TestCase
{
    public function testConstructorValidIpv4()
    {
        $res = new IpAddress('127.0.0.1');

        $this->assertInstanceOf(IpAddress::class, $res);
    }

    public function testConstructorValidIpv6()
    {
        $res = new IpAddress('2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertInstanceOf(IpAddress::class, $res);
    }

    public function testConstructorInvalidIp()
    {
        $res = new IpAddress('sadsadasd');

        $this->assertInstanceOf(IpAddress::class, $res);
    }

    public function testValidateValidIp()
    {
        $res = new IpAddress('127.0.0.1');

        $this->assertTrue($res->validate());
    }

    public function testProtocolteIpv4()
    {
        $res = new IpAddress('127.0.0.1');

        $this->assertEquals($res->protocol(), 'IPV4');
    }

    public function testProtocolIpv6()
    {
        $res = new IpAddress('2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertEquals($res->protocol(), 'IPV6');
    }

    public function testData()
    {
        $res = new IpAddress('127.0.0.1');

        $this->assertIsArray($res->data());
    }
}
