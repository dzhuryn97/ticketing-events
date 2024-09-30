<?php

namespace App\Presenter\Event\CancelEventSaga;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventInterface;
use Ticketing\Common\IntegrationEvent\Event\EventCanceledIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\EventCancellationCompletedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\EventCancellationStartedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Ticket\EventPaymentsRefundedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Ticket\EventTicketsArchivedIntegrationEvent;

/**
 * Implementation of saga pattern, to handle event cancellation, which need to execute transaction on several services.
 * Implementation made for educational purposes. Try to find solution for declarative describing saga.
 */
class CancelEventSaga
{
    public function __construct(
        private readonly EventBusInterface $eventBus,
        private readonly CancelEventSagaStateRepository $eventSagaStateRepository,
    ) {
    }

    public function startSaga(UuidInterface $eventId): void
    {
        $this->eventSagaStateRepository->createSagaState($eventId);
        $this->eventBus->publish(new EventCancellationStartedIntegrationEvent(
            $eventId
        ));
    }

    /**
     * @param IntegrationEventInterface|EventCanceledIntegrationEvent|EventCancellationStartedIntegrationEvent $event
     */
    public function handleIntegrationEvents(IntegrationEventInterface $event)
    {
        $sagaState = $this->getSagaState($event->eventId);

        switch ($sagaState->getCurrentState()) {
            case CancelEventSagaStateEnum::CANCELLATION_STARTED:
                $this->processWhenCancellationIsStarted($sagaState, $event);
                break;
            case CancelEventSagaStateEnum::PAYMENTS_REFUNDED:
                $this->processWhenPaymentsIsRefunded($sagaState, $event);
                break;
            case CancelEventSagaStateEnum::TICKETS_ARCHIVED:
                $this->processWhenTicketsIsArchived($sagaState, $event);
                break;
        }

        $this->eventSagaStateRepository->save($sagaState);
    }

    private function processWhenCancellationIsStarted(CancelEventSagaState $sagaState, IntegrationEventInterface $event): void
    {
        if ($event instanceof EventTicketsArchivedIntegrationEvent) {
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::TICKETS_ARCHIVED);
        }
        if ($event instanceof EventPaymentsRefundedIntegrationEvent) {
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::PAYMENTS_REFUNDED);
        }
    }

    private function processWhenPaymentsIsRefunded(CancelEventSagaState $sagaState, IntegrationEventInterface $event): void
    {
        if ($event instanceof EventTicketsArchivedIntegrationEvent) {
            $this->eventBus->publish(new EventCancellationCompletedIntegrationEvent(
                $event->eventId
            ));
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::CANCELLATION_COMPLETED);
        }
    }

    private function processWhenTicketsIsArchived(CancelEventSagaState $sagaState, IntegrationEventInterface $event): void
    {
        if ($event instanceof EventPaymentsRefundedIntegrationEvent) {
            $this->eventBus->publish(new EventCancellationCompletedIntegrationEvent(
                $event->eventId
            ));
            $sagaState->updateCurrentState(CancelEventSagaStateEnum::CANCELLATION_COMPLETED);
        }
    }

    private function getSagaState(UuidInterface $eventId): CancelEventSagaState
    {
        $sagaState = $this->eventSagaStateRepository->findByCorrelationId($eventId);
        if (!$sagaState) {
            throw new \InvalidArgumentException(sprintf('Saga CancelEventSaga with correlation id %s bot found', $eventId));
        }

        return $sagaState;
    }
}
