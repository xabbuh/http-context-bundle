<?php

namespace Openroot\Bundle\HttpContextBundle\Service;

use Openroot\Bundle\HttpContextBundle\Entity\Context;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpContextService
 *
 * @package Openroot\Bundle\HttpContextBundle\Service
 */
class HttpContextService
{
    /**
     * @var null|Context
     */
    private $context;

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function createContextByRequest(Request $request)
    {
        $this->createContext($request->getHost(), $request->getPort());
        return $this;
    }

    /**
     * @param string $httpHost
     * @param int    $httpPort
     *
     * @return $this
     */
    public function createContext($httpHost, $httpPort = 80)
    {
        if (!$this->hasContext()) {
            $this->context = new Context($httpHost, $httpPort);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasContext()
    {
        return (null !== $this->context);
    }

    /**
     * @return null|Context
     */
    public function getContext()
    {
        return $this->context;
    }
}