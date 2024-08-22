<?php

namespace App\Domain\TicketType;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class TicketTypeCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $ticketTypeId
    )
    {
        parent::__construct();
    }
}