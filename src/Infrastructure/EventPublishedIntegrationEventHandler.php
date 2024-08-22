<?php

namespace App\Infrastructure;

use Ticketing\Common\IntegrationEvent\Event\EventPublishedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\IntegrationEventHandlerInterface;

class EventPublishedIntegrationEventHandler implements IntegrationEventHandlerInterface
{
    public function __invoke(EventPublishedIntegrationEvent $event)
    {
        dump($event);
        // TODO: Implement __invoke() method.
    }
}