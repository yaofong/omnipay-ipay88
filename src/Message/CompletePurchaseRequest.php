<?php

namespace Omnipay\IPay88\Message;


class CompletePurchaseRequest extends PurchaseRequest
{
    protected $endpoint = 'https://www.mobile88.com/epayment/enquiry.asp';

    public function getData()
    {
        $data = $this->httpRequest->request->all();

        $data['ComputedSignature'] = '';

        return $data;
    }

    public function sendData($data)
    {
        $data['ReQueryStatus'] = '';

        return $this->response = new CompletePurchaseResponse($this, $data);
    }

}