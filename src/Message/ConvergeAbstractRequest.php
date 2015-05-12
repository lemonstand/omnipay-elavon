<?php namespace Omnipay\Elavon\Message;

use Omnipay\Common\CreditCard;

abstract class ConvergeAbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $testEndpoint = 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo';
    protected $liveEndpoint = 'https://www.myvirtualmerchant.com/VirtualMerchant';

    protected function getEndpoint()
    {
        return ($this->getTestMode()) ? $this->getTestEndpoint() : $this->getLiveEndpoint();
    }

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

    public function setSslShowForm($value)
    {
        return $this->setParameter('ssl_show_form', $value);
    }

    public function getSslShowForm()
    {
        return $this->getParameter('ssl_show_form');
    }

    public function getResultFormat()
    {
        return $this->getParameter('ssl_result_format');
    }

    public function setResultFormat($value)
    {
        return $this->setParameter('ssl_result_format', $value);
    }

    public function getTestEndpoint()
    {
        return $this->testEndpoint;
    }

    public function getLiveEndpoint()
    {
        return $this->liveEndpoint;
    }

    protected function createResponse($response)
    {
        return $this->response = new ConvergeResponse($this, $response);
    }

    protected function getBaseData()
    {
        $data = [
            'ssl_merchant_id' => $this->getMerchantId(),
            'ssl_user_id' => $this->getUsername(),
            'ssl_pin' => $this->getPassword(),
            'ssl_test_mode' => ($this->getTestMode()) ? 'true' : 'false',
            'ssl_show_form' => $this->getSslShowForm(),
            'ssl_result_format' => $this->getResultFormat()
        ];

        return $data;
    }
}
