<?php

namespace App\Domain\Event\Exception;

use Ramsey\Uuid\UuidInterface;

class EventNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $eventId)
    {
        parent::__construct(sprintf('The event with the identifier % was not found',$eventId));
    }
}