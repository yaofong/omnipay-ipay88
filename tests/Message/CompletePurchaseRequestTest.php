<?php

namespace Omnipay\IPay88\Message;


use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setMerchantKey('apple');

        $this->request->setMerchantCode('M00003');

        $this->getHttpRequest()->request->replace([
            'MerchantCode' => 'M00003',
            'PaymentId' => 2,
            'RefNo' => '12345',
            'Amount' => '100',
            'Currency' => 'MYR',
            'Remark' => '100',
            'TransId' => '54321',
            'AuthCode' => '',
            'Status' => 1,
            'ErrDesc' => '',
            'Signature' => 'sig123'
        ]);
    }

    public function testGetDataReturnCorrectComputedSignature()
    {
        $data = $this->request->getData();

        $this->assertSame('a4THdPHQG9jT3DPZZ/mabkXUqow=', $data['ComputedSignature']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseRequestReQuerySuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getRedirectUrl());
        $this->assertNull($response->getRedirectData());
        $this->assertSame('54321', $response->getTransactionReference());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('CompletePurchaseRequestReQuerySuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getRedirectUrl());
        $this->assertNull($response->getRedirectData());
        $this->assertSame('54321', $response->getTransactionReference());
    }

}
