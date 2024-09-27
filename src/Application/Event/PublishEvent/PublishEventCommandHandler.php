<?php

namespace App\Application\Event\PublishEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class PublishEventCommandHandler implements CommandHandlerInterface
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository,
    ) {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(PublishEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->id);
        if (!$event) {
            throw new EventNotFoundException($command->id);
        }

        $event->publish();

        $this->eventRepository->save($event);

    }
}
