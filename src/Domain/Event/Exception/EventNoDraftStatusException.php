<?php

namespace App\Domain\Event\Exception;

class EventNoDraftStatusException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The event is not in draft status');
    }
}