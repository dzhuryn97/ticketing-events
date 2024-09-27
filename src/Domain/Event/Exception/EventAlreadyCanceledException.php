<?php

namespace App\Domain\Event\Exception;

class EventAlreadyCanceledException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The event was already canceled');
    }
}
