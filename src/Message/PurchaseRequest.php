<?php

namespace Omnipay\IPay88\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{

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
        $this->validate(
            'card', 'amount', 'currency', 'description', 'transactionId', 'returnUrl', 'backendUrl'
        );

        return [
            'MerchantCode' => '',
            'PaymentId' => '',
            'RefNo' => '',
            'Amount' => '',
            'Currency' => '',
            'ProdDesc' => '',
            'UserName' => '',
            'UserEmail' => '',
            'UserContact' => '',
            'Remark' => '',
            'Lang' => '',
            'Signature' => '',
            'ResponseURL' => '',
            'BackendURL' => '',
        ];
    }

    /**
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

}