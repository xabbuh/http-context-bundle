<?php

namespace Openroot\Bundle\HttpContextBundle\Events;

use Openroot\Bundle\HttpContextBundle\Service\HttpContextService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestSubscriber
 *
 * @package Openroot\Bundle\HttpContextBundle\Events
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var HttpContextService
     */
    private $domainContextService;

    /**
     * @param HttpContextService $domainContextService
     */
    public function __construct(HttpContextService $domainContextService)
    {
        $this->domainContextService = $domainContextService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Locale listener
            KernelEvents::REQUEST => array(array('onRequest', 1023)),
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        $this->domainContextService->createContextByRequest($event->getRequest());
    }
}
