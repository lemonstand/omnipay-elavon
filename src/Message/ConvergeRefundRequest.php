<?php

namespace Omnipay\Elavon\Message;

/**
 * Elavon's Converge Return Request
 *
 * This class processes form post requests using the Elavon/Converge gateway as documented here:
 * https://resourcecentre.elavonpaymentgateway.com/index.php/download-developer-guide
 *
 * Also here: https://www.convergepay.com/converge-webapp/developer/#/welcome
 *
 * ### Test Mode
 *
 * In order to begin testing you will need the following parameters from Elavon/Converge:
 *
 * * merchantId, aka ssl_merchant_id
 * * username, aka ssl_user_id
 * * password, aka ssl_pin
 *
 * These parameters are issued for a short time only.  You need to contact Converge to request an extension
 * a few days before these parameters expire.
 *
 * ### Example
 *
 * #### Initialize Gateway
 *
 * <code>
 * //
 * // Put your gateway credentials here.
 * //
 * $credentials = array(
 *     'merchantId'        => '000000',
 *     'username'          => 'USERNAME',
 *     'password'          => 'PASSWORD'
 *     'testMode'          => true,            // Or false if you want to test production mode
 * );
 *
 * // Create a gateway object
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Elavon_Converge');
 *
 * // Initialise the gateway
 * $gateway->initialize($credentials);
 * </code>
 *
 * #### Direct Credit Card Completion
 *
 * <code>
 * try {
 *     $transaction = $gateway->refund(array(
 *         'amount'                 => '10.00',
 *         'transactionReference'   => '123456'
 *     ));
 *     $response = $transaction->send();
 *     $data = $response->getData();
 *     echo "Gateway capture response data == " . print_r($data, true) . "\n";
 *
 *     if ($response->isSuccessful()) {
 *         echo "Capture transaction was successful!\n";
 *     }
 * } catch (\Exception $e) {
 *     echo "Exception caught while attempting capture.\n";
 *     echo "Exception type == " . get_class($e) . "\n";
 *     echo "Message == " . $e->getMessage() . "\n";
 * }
 * </code>
 *
 * @link https://www.myvirtualmerchant.com/VirtualMerchant/
 * @link https://resourcecentre.elavonpaymentgateway.com/index.php/download-developer-guide
 * @see \Omnipay\Elavon\ConvergeGateway
 */
class ConvergeRefundRequest extends ConvergeTransactionManage
{

    protected $transactionType = 'ccreturn';

    protected function manageValidate()
    {
        $this->validate('transactionReference', 'amount');
    }
}
