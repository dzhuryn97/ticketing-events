<?php

namespace App\Domain\TicketType;

use Ramsey\Uuid\UuidInterface;

class TicketTypeNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $ticketId)
    {
        parent::__construct(sprintf('TicketType with identifier %s not found', $ticketId));
    }
}