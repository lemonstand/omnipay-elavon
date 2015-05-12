<?php namespace Omnipay\Elavon\Message;

class ConvergePurchaseRequest extends ConvergeAuthorizeRequest
{
    public function getData()
    {
        $this->transactionType = 'ccsale';
        $data = parent::getData();

        $data += [
            'ssl_first_name' => $this->getCard()->getFirstName(),
            'ssl_last_name' => $this->getCard()->getLastName(),
            'ssl_avs_address' => $this->getCard()->getBillingAddress1(),
            'ssl_city' => $this->getCard()->getCity(),
            'ssl_state' => $this->getCard()->getState(),
            'ssl_avs_zip' => $this->getCard()->getPostcode()
        ];

        return $data;
    }
}
