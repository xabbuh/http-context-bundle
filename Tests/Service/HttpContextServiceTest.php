<?php

namespace Openroot\Bundle\HttpContextBundle\Tests\Entity;

use Openroot\Bundle\HttpContextBundle\Service\HttpContextService;

require_once __DIR__ . '/../../Entity/Context.php';
require_once __DIR__ . '/../../Service/HttpContextService.php';

class HttpContextServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $host
     * @param $port
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRequest($host, $port)
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request', ['getHost', 'getPort']);
        $request
            ->expects($this->once())
            ->method('getHost')
            ->willReturn($host);
        $request
            ->expects($this->once())
            ->method('getPort')
            ->willReturn($port);

        return $request;
    }

    public function testContextCreationByRequest_1of2()
    {
        $request = $this->getMockRequest('www.example.com', 80);

        $service = new HttpContextService();
        $this->assertFalse($service->hasContext());
        $this->assertNull($service->getContext());

        $service->createContextByRequest($request);
        $this->assertInstanceOf('Openroot\Bundle\HttpContextBundle\Entity\Context', $service->getContext());
        $this->assertTrue($service->hasContext());
    }

    public function testContextCreationByRequest_2of2()
    {
        $request1 = $this->getMockRequest('www.example.com', 80);
        $request2 = $this->getMockRequest('www.example.net', 443);

        $service = new HttpContextService();

        // 1. context
        $service->createContextByRequest($request1);
        $context = $service->getContext();
        $this->assertEquals('www.example.com', $context->getHost());
        $this->assertEquals(80, $context->getPort());

        // 2. context (context aren't allowed to switch between requests)
        $service->createContextByRequest($request2);
        $context = $service->getContext();
        $this->assertEquals('www.example.com', $context->getHost());
        $this->assertEquals(80, $context->getPort());
    }

    public function testContextCreationByHand_1of2()
    {
        $service = new HttpContextService();
        $this->assertFalse($service->hasContext());
        $this->assertNull($service->getContext());

        $service->createContext('www.example.com', 80);
        $this->assertInstanceOf('Openroot\Bundle\HttpContextBundle\Entity\Context', $service->getContext());
        $this->assertTrue($service->hasContext());
    }

    public function testContextCreationByHand_2of2()
    {
        $service = new HttpContextService();

        // 1. context
        $service->createContext('www.example.com', 80);
        $context = $service->getContext();
        $this->assertEquals('www.example.com', $context->getHost());
        $this->assertEquals(80, $context->getPort());

        // 2. context (context aren't allowed to switch between requests)
        $service->createContext('www.example.net', 443);
        $context = $service->getContext();
        $this->assertEquals('www.example.com', $context->getHost());
        $this->assertEquals(80, $context->getPort());
    }
}