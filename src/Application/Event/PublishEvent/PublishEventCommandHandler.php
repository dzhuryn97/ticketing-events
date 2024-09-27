<?php

namespace App\Application\Event\PublishEvent;

use App\Domain\Event\EventRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class PublishEventCommandHandler implements CommandHandlerInterface
{
    private EventRepositoryInterface $eventRepository;
    private FlusherInterface $flusher;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        FlusherInterface $flusher,
    ) {
        $this->eventRepository = $eventRepository;
        $this->flusher = $flusher;
    }

    public function __invoke(PublishEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->id);
        $event->publish();

        $this->flusher->flush();
    }
}
