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
