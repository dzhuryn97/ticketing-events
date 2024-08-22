<?php

namespace App\Application\Event\CancelEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class CancelEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(CancelEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if(!$event){
            throw new EventNotFoundException($command->eventId);
        }
        $event->cancel(new \DateTimeImmutable());
        $this->flusher->flush();
    }
}