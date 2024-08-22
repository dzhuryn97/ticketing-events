<?php

namespace App\Application\Event\RescheduleEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class RescheduleEventCommandHandler implements CommandHandlerInterface
{
    private EventRepositoryInterface $eventRepository;
    private FlusherInterface $flusher;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        FlusherInterface         $flusher
    )
    {
        $this->eventRepository = $eventRepository;
        $this->flusher = $flusher;
    }

    public function __invoke(RescheduleEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if(!$event){
            throw new EventNotFoundException($command->eventId);
        }
        $event->reschedule($command->startsAt, $command->endsAt);

        $this->flusher->flush();
    }
}