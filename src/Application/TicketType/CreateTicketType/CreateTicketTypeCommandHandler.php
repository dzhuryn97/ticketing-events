<?php

namespace App\Application\TicketType\CreateTicketType;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\TicketType\TicketType;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class CreateTicketTypeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function __invoke(CreateTicketTypeCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if (!$event) {
            throw new EventNotFoundException($command->eventId);
        }

        $ticketType = new TicketType(
            $event,
            $command->name,
            $command->price,
            $command->currency,
            $command->quantity,
        );

        $this->ticketTypeRepository->add($ticketType);
        $this->flusher->flush();

        return $ticketType->getId();
    }
}
