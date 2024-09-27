<?php

namespace App\Presenter\Event\CancelEventSaga;

use App\Domain\Event\EventCanceledDomainEvent;
use Doctrine\ORM\EntityManagerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventInterface;
use Ticketing\Common\IntegrationEvent\Event\EventCanceledIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\EventCancellationCompletedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\EventCancellationStartedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Ticket\EventPaymentsRefundedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Ticket\EventTicketsArchivedIntegrationEvent;

class CancelEventSaga
{
    public function __construct(
        private readonly EventBusInterface $eventBus,
        private readonly CancelEventSagaRepository $eventSagaRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function handleEventCanceledDomainEvent(EventCanceledDomainEvent $event)
    {
        $this->eventSagaRepository->createSagaState($event->eventId);
        $this->eventBus->publish(new EventCancellationStartedIntegrationEvent(
            $event->eventId
        ));
        $this->em->flush();
    }

    /**
     * @param IntegrationEventInterface|EventCanceledIntegrationEvent|EventCancellationStartedIntegrationEvent $event
     */
    public function handleIntegrationEvents(IntegrationEventInterface $event)
    {
        $sagaState  = $this->eventSagaRepository->findByCorrelationId($event->eventId);

        if (!$sagaState) {
            throw new \InvalidArgumentException(sprintf('Saga with correlation id %s bot found', $event->eventId));
        }
        if (CancelEventSagaStateEnum::CANCELLATION_STARTED === $sagaState->getCurrentState()) {
            if ($event instanceof EventTicketsArchivedIntegrationEvent) {
                $sagaState->updateCurrentState(CancelEventSagaStateEnum::TICKETS_ARCHIVED);
            }
            if ($event instanceof EventPaymentsRefundedIntegrationEvent) {
                $sagaState->updateCurrentState(CancelEventSagaStateEnum::PAYMENTS_REFUNDED);
            }
            $this->em->flush();

            return;
        }


        if (CancelEventSagaStateEnum::PAYMENTS_REFUNDED === $sagaState->getCurrentState() && $event instanceof EventTicketsArchivedIntegrationEvent) {
            $this->eventBus->publish(new EventCancellationCompletedIntegrationEvent(
                $event->eventId
            ));
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::CANCELLATION_COMPLETED);
            $this->em->flush();

            return;
        }
        if (CancelEventSagaStateEnum::TICKETS_ARCHIVED === $sagaState->getCurrentState() && $event instanceof EventPaymentsRefundedIntegrationEvent) {
            $this->eventBus->publish(new EventCancellationCompletedIntegrationEvent(
                $event->eventId
            ));
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::CANCELLATION_COMPLETED);
            $this->em->flush();

            return;
        }
    }
}
