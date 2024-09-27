<?php

namespace App\Application\TicketType\UpdateTicketTypePrice;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class UpdateTicketTypePriceCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $ticketTypeId,
        public readonly float $price,
    ) {
    }
}
