<?php namespace Omnipay\Elavon\Message;

use Omnipay\Tests\TestCase;

class ConvergeGenerateTokenRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new ConvergeGenerateTokenRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'card' => $this->getValidCard(),
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ASCII',
            )
        );
    }

    public function testCreateCardSuccess()
    {
        $this->setMockHttpResponse('ConvergeCreateCardResponse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('7595301425001111', $response->getCardReference());
    }

}

