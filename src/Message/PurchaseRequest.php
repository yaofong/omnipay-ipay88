<?php

namespace Omnipay\IPay88\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    public function getBackendUrl()
    {
        return $this->getParameter('backendUrl');
    }

    public function setBackendUrl($backendUrl)
    {
        $this->setParameter('backendUrl', $backendUrl);
    }

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
            'card',
            'amount',
            'currency',
            'description',
            'transactionId',
            'returnUrl'
        );

        return [
            'MerchantCode' => $this->getMerchantCode(),
            'PaymentId' => '',
            'RefNo' => $this->getTransactionId(),
            'Amount' => number_format($this->getAmount(), 2),
            'Currency' => $this->getCurrency(),
            'ProdDesc' => $this->getDescription(),
            'UserName' => $this->getCard()->getBillingName(),
            'UserEmail' => $this->getCard()->getEmail(),
            'UserContact' => $this->getCard()->getNumber(),
            'Remark' => '',
            'Lang' => '',
            'Signature' => $this->signature(
                $this->getMerchantKey(),
                $this->getMerchantCode(),
                $this->getTransactionId(),
                $this->getAmount(),
                $this->getCurrency()
            ),
            'ResponseURL' => $this->getReturnUrl(),
            'BackendURL' => $this->getBackendUrl(),
        ];
    }

    /**
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    private function signature($merchantKey, $merchantCode, $refNo, $amount, $currency)
    {
        $amount = str_replace(array(',', '.'), '', $amount);

        $fullStringToHash = implode('', array($merchantKey, $merchantCode, $refNo, $amount, $currency));

        return base64_encode($this->hex2bin(sha1($fullStringToHash)));
    }

    private function hex2bin($hexSource)
    {
        $bin = '';
        for ($i = 0; $i < strlen($hexSource); $i = $i + 2) {
            $bin .= chr(hexdec(substr($hexSource, $i, 2)));
        }
        return $bin;
    }
}