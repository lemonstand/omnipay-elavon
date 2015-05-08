<?php namespace Omnipay\Elavon\Message;

use Omnipay\Common\CreditCard;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Test Endpoint URL
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo';

    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://www.myvirtualmerchant.com/VirtualMerchant';

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getTestEndpoint()
    {
        return $this->testEndpoint;
    }

    public function getLiveEndpoint()
    {
        return $this->liveEndpoint;
    }

    /**
     * Get API endpoint URL
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return ($this->getTestMode()) ? $this->getTestEndpoint() : $this->getLiveEndpoint();
    }

    /**
     * Get HTTP Method
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Get Content Type
     *
     * This is nearly always 'text/xml; charset=utf-8' but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getContentType()
    {
        return 'text/xml; charset=utf-8';
    }

    /**
     * Send Data
     *
     * @param \SimpleXMLElement $data Data
     *
     * @access public
     * @return RedirectResponse
     */
    public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data->asXML()
        );

        $httpResponse = $httpRequest
            ->setHeader('Content-Type', $this->getContentType())
            ->send()
            ->xml();

        return $this->createResponse($httpResponse);
    }
}
