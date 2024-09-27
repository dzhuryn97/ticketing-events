<?php

namespace App\Application\TicketType\CreateTicketType;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\TicketType\TicketType;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateTicketTypeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
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

        return $ticketType->getId();
    }
}
