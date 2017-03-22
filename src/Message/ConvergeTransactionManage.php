<?php

namespace Omnipay\Elavon\Message;

/**
 * Class ConvergeTransactionManage
 *
 * This is a base class used in requests that manage an existing transaction
 *
 * @package Omnipay\Elavon\Message
 */
abstract class ConvergeTransactionManage extends ConvergeAbstractRequest
{

    protected $transactionType;

    /**
     * Get the data needed for a transaction modification
     *
     * @return array
     */
    public function getData()
    {
        $this->manageValidate();

        $data = array(
            'ssl_transaction_type'=>$this->transactionType,
            'ssl_txn_id'=>$this->getTransactionReference(),
            'ssl_amount'=>$this->getAmount()
        );

        return array_merge($this->getBaseData(), $data);
    }

    abstract protected function manageValidate();
}
