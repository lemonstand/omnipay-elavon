<?php namespace Omnipay\Vantiv\Message;

use Omnipay\Tests\TestCase;

class ConvergeAuthorizeRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new ConvergeAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => 10.00,
                'card' => $this->getValidCard()
                'ssl_salestax' => 2.00,
                'ssl_invoice_number' => 1,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ASCII',
                'vgm_business_unit_id' => 'lemon',
                'unique_identifier' => 'lemon'
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('10.00', (string) $data['ssl_amount']);
        $this->assertSame('2.00', (string) $data['ssl_salestax']);
        $this->assertSame('1', (string) $data['ssl_invoice_number']);
        $this->assertSame('false', $data['ssl_show_form']);
        $this->assertSame('ASCII', $data['ssl_result_format']);
        $this->assertSame('ccauthonly', $data['ssl_transaction_type']);
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('ConvergePurchaseResponse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('APPROVED', $response->getMessage());
        $this->assertSame('0', $response->getCode());
    }

    public function testAuthorizeNoVID()
    {
        $this->setMockHttpResponse('NoVIDFailureResponse.txt');
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('The VirtualMerchant ID was not supplied in the authorization request.', $response->getMessage());
        $this->assertSame('4000', $response->getCode());
    }

    public function testAuthorizeNoPIN()
    {
        $this->setMockHttpResponse('NoPINFailureResponse.txt');
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('The PIN was not supplied in the authorization request.', $response->getMessage());
        $this->assertSame('4013', $response->getCode());
    }
}
