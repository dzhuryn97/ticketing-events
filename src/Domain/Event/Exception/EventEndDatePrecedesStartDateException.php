<?php

namespace App\Domain\Event\Exception;

class EventEndDatePrecedesStartDateException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The event end date precedes the start date');
    }
    // The event end date precedes the start date
}
