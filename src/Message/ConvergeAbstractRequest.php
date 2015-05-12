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

    public function getSslShowForm()
    {
        return $this->getParameter('ssl_show_form');
    }

    public function setSslShowForm($value)
    {
        return $this->setParameter('ssl_show_form', $value);
    }

    public function getSslResultFormat()
    {
        return $this->getParameter('ssl_result_format');
    }

    public function setSslResultFormat($value)
    {
        return $this->setParameter('ssl_result_format', $value);
    }

    public function getSslSalesTax()
    {
        return $this->getParameter('ssl_salestax');
    }

    public function setSslSalesTax($value)
    {
        return $this->setParameter('ssl_salestax', $value);
    }

    public function getSslInvoiceNumber()
    {
        return $this->getParameter('ssl_invoice_number');
    }

    public function setSslInvoiceNumber($value)
    {
        return $this->setParameter('ssl_invoice_number', $value);
    }

    public function getSslFirstName()
    {
        return $this->getParameter('ssl_first_name');
    }

    public function setSslFirstName($value)
    {
        return $this->setParameter('ssl_first_name', $value);
    }

    public function getSslLastName()
    {
        return $this->getParameter('ssl_last_name');
    }

    public function setSslLastName($value)
    {
        return $this->setParameter('ssl_last_name', $value);
    }

    public function getUniqueIdentifier()
    {
        return $this->getParameter('unique_identifier');
    }

    public function setUniqueIdentifier($value)
    {
        return $this->setParameter('unique_identifier', $value);
    }

    public function getVgmBusinessUnitId()
    {
        return $this->getParameter('vgm_business_unit_id');
    }

    public function setVgmBusinessUnitId($value)
    {
        return $this->setParameter('vgm_business_unit_id', $value);
    }

    public function getSslTxnCurrencyCode()
    {
        return $this->getParameter('ssl_txn_currency_code');
    }

    public function setSslTxnCurrencyCode($value)
    {
        return $this->setParameter('ssl_txn_currency_code', $value);
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
            'ssl_result_format' => $this->getSslResultFormat(),
            'ssl_invoice_number' => $this->getSslInvoiceNumber(),
            'unique_identifier' => $this->getUniqueIdentifier(),
            'vgm_business_unit_id' => $this->getVgmBusinessUnitId()
        ];

        return $data;
    }
}
