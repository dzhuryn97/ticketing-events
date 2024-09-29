<?php

namespace App\Domain\TicketType\Exception;

use App\Domain\TicketType\TicketType;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class TicketTypeNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $ticketId)
    {
        parent::__construct($ticketId, TicketType::class);
    }
}
