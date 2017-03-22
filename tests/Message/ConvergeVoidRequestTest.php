<?php

namespace Omnipay\Elavon\Message;


use Omnipay\Tests\TestCase;

class ConvergeVoidRequestTest extends TestCase
{
    /** @var  ConvergeVoidRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new ConvergeVoidRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'transactionReference'=>'00000000-0000-0000-0000-00000000000'
            )
        );
    }

    public function testTransactionReference()
    {
        $this->assertEquals('00000000-0000-0000-0000-00000000000', $this->request->getTransactionReference());
        $this->assertSame($this->request, $this->request->setTransactionReference('test'));
        $this->assertEquals('test', $this->request->getTransactionReference());
        $this->request->setTransactionReference('00000000-0000-0000-0000-00000000000');
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('ConvergeVoidResponse.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('APPROVED', $response->getMessage());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('00000000-0000-0000-0000-00000000000', $response->getTransactionReference());
    }
}
