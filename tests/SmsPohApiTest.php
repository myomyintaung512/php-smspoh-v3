<?php

use PHPUnit\Framework\TestCase;
use myomyintaung512\smspoh\SmsPohApi;

class SmsPohApiTest extends TestCase
{
    private $apiKey = 'test_api_key';
    private $apiSecret = 'test_api_secret';

    public function testInitialization()
    {
        $smsApi = new SmsPohApi($this->apiKey, $this->apiSecret);
        $this->assertInstanceOf(SmsPohApi::class, $smsApi);
    }

    public function testGetBalance()
    {
        $smsApi = $this->getMockBuilder(SmsPohApi::class)
            ->setConstructorArgs([$this->apiKey, $this->apiSecret])
            ->onlyMethods(['getBalance'])
            ->getMock();

        $smsApi->expects($this->once())
            ->method('getBalance')
            ->willReturn(['balance' => 100.00]);

        $balance = $smsApi->getBalance();
        $this->assertIsArray($balance);
        $this->assertArrayHasKey('balance', $balance);
        $this->assertEquals(100.00, $balance['balance']);
    }
}
