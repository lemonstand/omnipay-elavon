<?php namespace Omnipay\Elavon;

use Omnipay\Common\AbstractGateway;

/**
 * Elavon's Converge Gateway
 *
 * @link https://www.myvirtualmerchant.com/VirtualMerchant/
 */
class ConvergeGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Converge';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'username' => '',
            'password' => '',
            'ssl_show_form' => false,
            'ssl_result_format' => 'ASCII',
        );
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

    /**
     * @param array $parameters
     * @return \Omnipay\Elavon\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Elavon\Message\ConvergeAuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Elavon\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Elavon\Message\ConvergePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Elavon\Message\PurchaseRequest
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Elavon\Message\ConvergeGenerateTokenRequest', $parameters);
    }
}
