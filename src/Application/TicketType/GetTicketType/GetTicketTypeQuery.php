<?php

namespace App\Application\TicketType\GetTicketType;

use App\Domain\TicketType\TicketType;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<TicketType>
 */
class GetTicketTypeQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $ticketTypeId,
    ) {
    }
}
