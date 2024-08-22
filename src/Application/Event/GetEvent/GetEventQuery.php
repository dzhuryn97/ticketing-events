<?php

namespace App\Application\Event\GetEvent;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<Event>
 */
class GetEventQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $eventId
    )
    {
    }
}