<?php namespace Omnipay\Elavon\Message;

use Omnipay\Tests\TestCase;

class ConvergePurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new ConvergePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => 10.00,
                'card' => $this->getValidCard(),
                'ssl_salestax' => 1.23,
                'ssl_invoice_number' => 1,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ASCII',
            )
        );
    }

    public function testSslFirstName()
    {
        $this->assertSame($this->request, $this->request->setSslFirstName('Test'));
        $this->assertSame('Test', $this->request->getSslFirstName());
    }

    public function testSslLastName()
    {
        $this->assertSame($this->request, $this->request->setSslLastName('Mann'));
        $this->assertSame('Mann', $this->request->getSslLastName());
    }

    public function testGetTestEndpoint()
    {
        $this->assertSame($this->request, $this->request->setTestMode(true));
        $this->assertSame('https://demo.myvirtualmerchant.com/VirtualMerchantDemo', $this->request->getEndpoint());
    }

    public function testGetLiveEndpoint()
    {
        $this->assertSame($this->request, $this->request->setTestMode(false));
        $this->assertSame('https://www.myvirtualmerchant.com/VirtualMerchant', $this->request->getEndpoint());
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('10.00', (string) $data['ssl_amount']);
        $this->assertSame('1.23', (string) $data['ssl_salestax']);
        $this->assertSame('1', (string) $data['ssl_invoice_number']);
        $this->assertSame('false', $data['ssl_show_form']);
        $this->assertSame('ASCII', $data['ssl_result_format']);
        $this->assertSame('ccsale', $data['ssl_transaction_type']);
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('ConvergePurchaseResponse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('APPROVED', $response->getMessage());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('00000000-0000-0000-0000-00000000000', $response->getTransactionReference());
    }

    public function testPurchaseNoVID()
    {
        $this->setMockHttpResponse('NoVIDFailureResponse.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('The VirtualMerchant ID was not supplied in the authorization request.', $response->getMessage());
        $this->assertSame('4000', $response->getCode());
    }

    public function testPurchaseNoPIN()
    {
        $this->setMockHttpResponse('NoPINFailureResponse.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('The PIN was not supplied in the authorization request.', $response->getMessage());
        $this->assertSame('4013', $response->getCode());
    }

    public function testPurchaseChargeCardToken()
    {
        $this->setMockHttpResponse('ConvergePurchaseCreditCardToken.txt');

        $request = new ConvergePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(
            array(
                'amount'    => 10.00,
                'token'     => '7595301425001111',
                'cardReference' => '7595301425001111',
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ASCII',
                'merchantId' => 'testmerchant1',
                'username' => 'testusername1',
                'password' => 'testpassword1',
                'currency' => 'USD'
            )
        );

        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('APPROVED', $response->getMessage());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('00000000-0000-0000-0000-00000000000', $response->getTransactionReference());
    }

}
