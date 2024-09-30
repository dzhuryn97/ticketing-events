<?php

namespace App\Presenter\Event\CancelEventSaga;

use App\Domain\Event\EventCanceledDomainEvent;
use Ticketing\Common\Application\DomainEventHandlerInterface;

/**
 * Think about avoiding DomainEventHandlers outside of Application Layer.
 */
class EventCanceledDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly CancelEventSaga $cancelEventSaga,
    ) {
    }

    public function __invoke(EventCanceledDomainEvent $event)
    {
        $this->cancelEventSaga->startSaga($event->eventId);
    }
}
