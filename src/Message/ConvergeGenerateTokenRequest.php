<?php namespace Omnipay\Elavon\Message;

class ConvergeGenerateTokenRequest extends ConvergeAbstractRequest
{
    protected $transactionType = 'ccgettoken';

    public function getData()
    {
        $data = array(
            'ssl_transaction_type' => $this->transactionType,
            'ssl_amount' => $this->getAmount(),
            'ssl_salestax' => $this->getSslSalesTax(),

            'ssl_card_number' => $this->getCard()->getNumber(),
            'ssl_exp_date' => $this->getCard()->getExpiryDate('my'),
            'ssl_cvv2cvc2' => $this->getCard()->getCvv(),
            'ssl_cvv2cvc2_indicator' => ($this->getCard()->getCvv()) ? 1 : 0,

            'ssl_verify' => 'N',

            'ssl_first_name' => $this->getCard()->getFirstName(),
            'ssl_last_name' => $this->getCard()->getLastName(),
            'ssl_avs_address' => $this->getCard()->getAddress1(),
            'ssl_address2' => $this->getCard()->getAddress2(),
            'ssl_city' => $this->getCard()->getCity(),
            'ssl_state' => $this->getCard()->getState(),
            'ssl_country' => $this->getCard()->getCountry(),
            'ssl_add_token' => 'Y',

            'ssl_show_form' => 'false',
            'ssl_result_format' => 'ASCII',
        );

        return array_merge($this->getBaseData(), $data);
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint() . '/process.do', null, http_build_query($data))
            ->setHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->send();

        return $this->createResponse($httpResponse->getBody());
    }
}
