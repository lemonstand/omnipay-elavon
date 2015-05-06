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
}
