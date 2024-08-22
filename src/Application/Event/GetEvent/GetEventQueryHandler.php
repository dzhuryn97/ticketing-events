<?php

namespace App\Application\Event\GetEvent;

use App\Domain\Event\Event;
use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetEventQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository
    )
    {
    }

    public function __invoke(GetEventQuery $query): Event
    {
        $event = $this->eventRepository->findById($query->eventId);
        if(!$event){
            throw new EventNotFoundException($query->eventId);
        }

        return $event;
    }
}