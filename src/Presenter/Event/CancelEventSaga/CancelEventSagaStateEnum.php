<?php

namespace App\Presenter\Event\CancelEventSaga;

enum CancelEventSagaStateEnum: string
{
    case CANCELLATION_STARTED = 'cancellationStarted';
    case PAYMENTS_REFUNDED = 'paymentsRefunded';
    case TICKETS_ARCHIVED = 'ticketsArchived';
    case CANCELLATION_COMPLETED = 'cancellationCompleted';
}
