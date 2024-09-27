<?php

namespace App\Application\Event\RescheduleEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class RescheduleEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $eventId,
        public readonly \DateTimeImmutable $startsAt,
        public readonly ?\DateTimeImmutable $endsAt,
    ) {
    }
}
