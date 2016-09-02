<?php

namespace Omnipay\IPay88\Message;


use Omnipay\Common\Message\AbstractResponse;

class PurchaseResponse extends AbstractResponse
{
    protected $endpoint = 'https://www.mobile88.com/ePayment/entry.asp';

    public function isSuccessful()
    {
        return false;
    }

    public function getRedirectUrl()
    {
        return $this->endpoint;
    }



}