<?php

namespace Omnipay\IPay88;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    /** @var array */
    private $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setMerchantKey('apple');

        $this->gateway->setMerchantCode('M00003');

        $this->options = [
            'card' => [
                'firstName' => 'Xu',
                'email' => 'xuding@spacebib.com',
                'number' => '93804194'
            ],
            'amount' => '1230.50',
            'currency' => 'MYR',
            'description' => 'Marina Run 2016',
            'transactionId' => 'A00000001',
            'returnUrl' => 'https://www.example.com/return',
        ];
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->gateway);
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase($this->options)->send();


        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectResponse());
    }

    public function testCompletePurchase()
    {
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

        $this->setMockHttpResponse('CompletePurchaseRequestReQuerySuccess.txt');

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('54321', $response->getTransactionReference());
    }
}
