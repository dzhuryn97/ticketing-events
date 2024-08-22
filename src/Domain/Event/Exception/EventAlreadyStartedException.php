<?php

namespace App\Domain\Event\Exception;

class EventAlreadyStartedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The event has already started');
    }
}