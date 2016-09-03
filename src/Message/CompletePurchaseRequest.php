<?php

namespace Omnipay\IPay88\Message;


class CompletePurchaseRequest extends AbstractRequest
{
    protected $endpoint = 'https://www.mobile88.com/epayment/enquiry.asp';

    public function getData()
    {
        $this->guardParameters();

        $data = $this->httpRequest->request->all();

        $data['ComputedSignature'] = $this->signature(
            $this->getMerchantKey(),
            $this->getMerchantCode(),
            $data['PaymentId'],
            $data['RefNo'],
            $data['Amount'],
            $data['Currency'],
            $data['Status']
        );

        return $data;
    }

    public function sendData($data)
    {
        $data['ReQueryStatus'] = $this->httpClient->post($this->endpoint, null, [
            'MerchantCode' => $this->getMerchantCode(),
            'RefNo' => $data['RefNo'],
            'Amount' => number_format($data['Amount']),
        ])->send()->getBody(true);

        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    protected function signature($merchantKey, $merchantCode, $paymentId, $refNo, $amount, $currency, $status)
    {
        $amount = str_replace([',', '.'], '', $amount);

        $paramsInArray = [$merchantKey, $merchantCode, $paymentId, $refNo, $amount, $currency, $status];

        return $this->createSignatureFromString(implode('', $paramsInArray));
    }
}