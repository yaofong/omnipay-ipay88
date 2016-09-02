<?php

namespace Omnipay\IPay88\Message;


class CompletePurchaseRequest extends PurchaseRequest
{
    protected $endpoint = '';

    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($merchantKey)
    {
        $this->setParameter('merchantKey', $merchantKey);
    }

    public function getMerchantCode()
    {
        return $this->getParameter('merchantCode');
    }

    public function setMerchantCode($merchantCode)
    {
        $this->setParameter('merchantCode', $merchantCode);
    }

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