<?php

namespace Omnipay\IPay88\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setMerchantKey('apple');

        $this->request->setMerchantCode('M00003');

        $this->request->initialize(
            array(
                'card' => [
                    'firstName' => 'Xu',
                    'email' => 'xuding@spacebib.com',
                    'number' => '93804194'
                ],
                'amount' => '1230.50',
                'currency' => 'MYR',
                'description' => 'Marina Run 2016',
                'transactionId' => 'A00000001',
                'returnUrl' => 'https://www.example.com/return'
            )
        );

    }

    public function testGetData()
    {
        $result = $this->request->getData();

        $expected = [
            'MerchantCode' => '12345',
            'PaymentId' => '',
            'RefNo' => 'A00000001',
            'Amount' => number_format('1230.50'),
            'Currency' => 'MYR',
            'ProdDesc' => 'Marina Run 2016',
            'UserName' => 'Xu',
            'UserEmail' => 'xuding@spacebib.com',
            'UserContact' => '93804194',
            'Remark' => '',
            'Lang' => '',
            'Signature' => '84dNMbfgjLMS42IqSTPqQ99cUGA=',
            'ResponseURL' => 'https://www.example.com/return',
            'BackendURL' => 'https://www.example.com/backend',
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetData_Signature()
    {
        $signature = '84dNMbfgjLMS42IqSTPqQ99cUGA=';

        $result = $this->request->getData()['Signature'];
        $this->assertEquals($signature, $result);

        $this->request->setMerchantKey('orange');
        $result = $this->request->getData()['Signature'];
        $this->expectNotEquals($signature, $result);
    }

}
