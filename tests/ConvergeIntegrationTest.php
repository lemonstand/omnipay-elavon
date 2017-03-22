<?php

namespace Omnipay\Elavon;


use Omnipay\Tests\TestCase;

/**
 * Class ConvergeIntegrationTest
 *
 * This is an integration test class so it actually sends messages to Elavon. This means you will need to setup a
 * test account with them and get your Merchant ID and API Passcode. Once you have those, you can create a new file in
 * the Mock folder called myCredentials.json and format it as below:
 *
 * {
 *      "merchantId":"<Your Merchant ID here>",
 *      "username":"<Your Username here>",
 *      "password":"<Your Password here>"
 * }
 *
 * If that file does not exist or is not formatted in this way, all tests in this class will be skipped.
 *
 * Beware that test accounts on Elavon are temporary so if it has been a while since you setup your account you might need
 * to setup a new one or remove your credentials from the myCredentials file so the variables are empty and these tests
 * will be skipped.
 *
 * @package Omnipay\Elavon
 */
class ConvergeIntegrationTest extends TestCase
{
    /** @var  ConvergeGateway */
    protected $gateway;

    /**
     * Check the myCredentials file to make sure it exists and has the needed data. If there are any problems skip the tests.
     * If there are not, instantiate the object.
     */
    public function setUp()
    {
        $merchantId = '';
        $username = '';
        $password = '';
        $credentialsFilePath = dirname(__FILE__) . '/Mock/myCredentials.json';

        if(file_exists($credentialsFilePath)) {
            $credentialsJson = file_get_contents($credentialsFilePath);
            if($credentialsJson) {
                $credentials = json_decode($credentialsJson);
                $merchantId = $credentials->merchantId;
                $username = $credentials->username;
                $password = $credentials->password;
            }
        }

        if(empty($merchantId) || empty($username) || empty($password)) {
            $this->markTestSkipped();
        } else {
            $this->gateway = new ConvergeGateway();
            $this->gateway->setMerchantId($merchantId);
            $this->gateway->setUsername($username);
            $this->gateway->setPassword($password);
            $this->gateway->setTestMode(true);
        }
    }

    /**
     * Test an authorization only followed by the capture of that transaction
     */
    public function testAuthCapture()
    {
        $authResponse = $this->gateway->authorize(
            array(
                'amount'=>'10.00',
                'card'=>$this->getValidCard(),
                'ssl_invoice_number'=>'1',
                'integrationTesting'=>true
            )
        )->send();
        $this->assertTrue($authResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $authResponse->getMessage());

        $captureResponse = $this->gateway->capture(
            array(
                'amount'=>'10.00',
                'transactionReference'=>$authResponse->getTransactionReference(),
                'integrationTesting'=>true
            )
        )->send();

        $this->assertTrue($captureResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $captureResponse->getMessage());
    }

    /**
     * Test a purchase followed by a refund of that purchase
     */
    public function testPurchaseRefund()
    {
        $purchaseResponse = $this->gateway->purchase(
            array(
                'amount'=>'20.00',
                'card'=>$this->getValidCard(),
                'ssl_invoice_number'=>2,
                'integrationTesting'=>true
            )
        )->send();

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $purchaseResponse->getMessage());

        $refundResponse = $this->gateway->refund(
            array(
                'amount'=>'20.00',
                'transactionReference'=>$purchaseResponse->getTransactionReference(),
                'integrationTesting'=>true
            )
        )->send();

        $this->assertTrue($refundResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $refundResponse->getMessage());
    }


    /**
     * Test a purchase followed by a void of that purchase
     */
    public function testPurchaseVoid()
    {
        $purchaseResponse = $this->gateway->purchase(
            array(
                'amount'=>'30.00',
                'card'=>$this->getValidCard(),
                'ssl_invoice_number'=>3,
                'integrationTesting'=>true
            )
        )->send();

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $purchaseResponse->getMessage());

        $voidResponse = $this->gateway->void(
            array(
                'transactionReference'=>$purchaseResponse->getTransactionReference(),
                'integrationTesting'=>true
            )
        )->send();

        $this->assertTrue($voidResponse->isSuccessful());
        $this->assertEquals('APPROVAL', $voidResponse->getMessage());
    }

    /**
     * This allows for the usage of Elavon's test card data instead of using the default data from Omnipay
     *
     * @return array
     */
    public function getValidCard()
    {
        $card = parent::getValidCard();
        $card['number'] = '4124939999999990';
        $card['expiryMonth'] = '12';
        $card['expiryYear'] = '19';

        return $card;

    }
}