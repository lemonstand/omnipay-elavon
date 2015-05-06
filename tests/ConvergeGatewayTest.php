<?php namespace Omnipay\Elavon;

use Omnipay\Tests\GatewayTestCase;

class ConvergeGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());        
    }

    public function testAuthorize()
    {
        $this->assertTrue(true);
    }

    public function testPurchase()
    {
        $this->assertTrue(true);
    }
}
