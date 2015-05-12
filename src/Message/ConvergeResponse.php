<?php namespace Omnipay\Elavon\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class ConvergeResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        parse_str(implode('&', preg_split('/\n/', $data)), $this->data);
    }

    public function isSuccessful()
    {
        return (isset($this->data['ssl_result']) && $this->data['ssl_result'] == 0);
    }

    public function getTransactionReference()
    {
        return (isset($this->data['ssl_txn_id'])) ? $this->data['ssl_txn_id'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['ssl_result_message']) ? $this->data['ssl_result_message'] : null;
    }
}
