<?php

namespace App\Application\TicketType\CreateTicketType;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

/**
 * @implements CommandInterface<UuidInterface>
 */
class CreateTicketTypeCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $eventId,
        public readonly string $name,
        public readonly float $price,
        public readonly string $currency,
        public readonly int $quantity,
    )
    {
    }
}