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

    public function testAuthCapture()
    {
        $authResponse = $this->gateway->authorize(
            array(
                'amount'=>'10.00',
                'card'=>$this->getValidCard(),
                'ssl_invoice_number'=>'1'
            )
        )->send();
        $this->assertTrue($authResponse->isSuccessful());
        echo '<pre>';
        print_r($authResponse->getData());
        echo '</pre>';
    }
}