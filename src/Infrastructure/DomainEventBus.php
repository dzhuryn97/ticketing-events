<?php

namespace App\Infrastructure;

use Symfony\Component\Messenger\MessageBusInterface;

class DomainEventBus implements \App\Application\DomainEventDispatcher
{
    private MessageBusInterface $eventBus;

    public function __construct(
        MessageBusInterface $eventBus,
    ) {
        $this->eventBus = $eventBus;
    }

    public function dispatch(object $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
