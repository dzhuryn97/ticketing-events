<?php

namespace App\Application\Event\RescheduleEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class RescheduleEventCommandHandler implements CommandHandlerInterface
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository,
    ) {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(RescheduleEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if (!$event) {
            throw new EventNotFoundException($command->eventId);
        }

        $event->reschedule($command->startsAt, $command->endsAt);

        $this->eventRepository->save($event);
    }
}
