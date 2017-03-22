<?php

namespace Omnipay\Elavon\Message;


use Omnipay\Tests\TestCase;

class ConvergeRefundRequestTest extends TestCase
{
    /** @var  ConvergeRefundRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new ConvergeRefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'transactionReference'=>'00000000-0000-0000-0000-00000000000',
                'amount'=>10.00
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

    public function testAmount()
    {
        $this->assertEquals('10.00', $this->request->getAmount());
        $this->assertSame($this->request, $this->request->setAmount(15.00));
        $this->assertEquals('15.00', $this->request->getAmount());
        $this->request->setAmount(10.00);
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('ConvergeRefundResponse.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('APPROVED', $response->getMessage());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('00000000-0000-0000-0000-00000000000', $response->getTransactionReference());
    }
}
