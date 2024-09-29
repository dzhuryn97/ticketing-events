<?php

namespace App\Domain\Event\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class EventEndDatePrecedesStartDateException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('The event end date precedes the start date', 'EventEndDatePrecedesStartDate');
    }
}
