<?php

namespace App\Domain\Event\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class EventNoDraftStatusException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('The event is not in draft status', 'EventNoDraftStatus');
    }
}
