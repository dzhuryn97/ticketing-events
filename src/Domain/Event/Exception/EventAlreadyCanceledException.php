<?php

namespace App\Domain\Event\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class EventAlreadyCanceledException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('The event was already canceled', 'EventAlreadyCanceled');
    }
}
