<?php

namespace Openroot\Bundle\HttpContextBundle\Tests\Entity;

use Openroot\Bundle\HttpContextBundle\Entity\Context;

require_once __DIR__ . '/../../Entity/Context.php';

/**
 * Class ContextEntityTest
 *
 * @package Openroot\Bundle\HttpContextBundle\Tests\Entity
 */
class ContextEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testGetter()
    {
        $host = 'localhost';
        $port = 8080;

        // create
        $context = new Context($host, $port);

        // Assert
        $this->assertEquals($host, $context->getHost());
        $this->assertEquals($port, $context->getPort());
        $this->assertEquals(sprintf('%s:%s', $host, $port), (string)$context);
    }

    public function testValueNormalization()
    {
        $host = 123456;
        $port = '8080';

        // create
        $context = new Context($host, $port);

        // Assert
        $this->assertInternalType('string', $context->getHost());
        $this->assertNotInternalType('integer', $context->getHost());

        $this->assertInternalType('integer', $context->getPort());
        $this->assertNotInternalType('string', $context->getPort());
    }
}
