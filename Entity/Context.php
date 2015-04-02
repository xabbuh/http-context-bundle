<?php

namespace Openroot\Bundle\HttpContextBundle\Entity;

/**
 * Class Context
 *
 * @package Openroot\Bundle\HttpContextBundle\Entity
 */
class Context
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @param string $host
     * @param int    $port
     */
    public function __construct($host, $port)
    {
        $this->host = (string)$host;
        $this->port = (int)$port;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s:%s', $this->getHost(), $this->getPort());
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
}
