<?php

namespace App\Domain\Event\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class EventAlreadyStartedException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('The event has already started', 'EventAlreadyStarted');
    }
}
