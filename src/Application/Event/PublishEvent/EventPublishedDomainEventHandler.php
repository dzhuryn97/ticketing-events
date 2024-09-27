<?php

namespace App\Application\Event\PublishEvent;

use App\Domain\Event\EventPublishedDomainEvent;
use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\TicketType\TicketType;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\Event\EventPublishedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\TicketTypeModel;

class EventPublishedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(EventPublishedDomainEvent $domainEvent)
    {
        $event = $this->eventRepository->findById($domainEvent->eventId);

        if (!$event) {
            throw new EventNotFoundException($domainEvent->eventId);
        }

        $ticketTypes = $this->ticketTypeRepository->getByEvent($event);

        $integrationEvent = new EventPublishedIntegrationEvent(
            $domainEvent->id,
            $domainEvent->occurredOn,
            $domainEvent->eventId,
            $event->getTitle(),
            $event->getDescription(),
            $event->getLocation(),
            $event->getStartsAt(),
            $event->getEndsAt(),
            array_map(function (TicketType $ticketType) {
                return new TicketTypeModel(
                    $ticketType->getId(),
                    $ticketType->getEvent()->getId(),
                    $ticketType->getName(),
                    $ticketType->getPrice(),
                    $ticketType->getCurrency(),
                    $ticketType->getQuantity(),
                );
            }, $ticketTypes)
        );

        $this->eventBus->publish($integrationEvent);
    }
}
