<?php namespace Omnipay\Elavon\Message;

class ConvergeAuthorizeRequest extends ConvergeAbstractRequest
{
    protected $transactionType = 'ccauthonly';

    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();
        $data = $this->getBaseData();

        $data += [
            'ssl_amount' => $this->getAmount(),
            'ssl_salestax' => $this->getSslSalesTax(),
            'ssl_transaction_type' => $this->transactionType,
            'ssl_card_number' => $this->getCard()->getNumber(),
            'ssl_exp_date' => $this->getCard()->getExpiryDate('my'),
            'ssl_cvv2cvc2' => $this->getCard()->getCvv(),
            'ssl_cvv2cvc2_indicator' => ($this->getCard()->getCvv()) ? 1 : 0,
        ];

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint() . '/process.do', null, http_build_query($data))
            ->setHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->send();

        return $this->createResponse($httpResponse->getBody());
    }
}
