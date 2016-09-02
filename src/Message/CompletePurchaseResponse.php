<?php

namespace Omnipay\IPay88\Message;


use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    private $reQueryResponse = [
        '00' => 'Successful payment',
        'Invalid parameters' => 'Parameters pass in incorrect',
        'Record not found' => 'Cannot found the record',
        'Incorrect amount' => 'Amount different',
        'Payment fail' => 'Payment fail',
        'M88Admin' => 'Payment status updated by iPay88 Admin(Fail)'
    ];

    private $invalidSignatureMsg = 'Invalid signature returned from iPay88';

    public function isSuccessful()
    {
        // TODO: Implement isSuccessful() method.
    }
}