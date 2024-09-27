<?php

namespace App\Domain\Event;

enum EventStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Completed = 'completed';
    case Canceled = 'canceled';
}
