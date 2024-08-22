<?php

namespace App\Application\TicketType\UpdateTicketTypePrice;

use App\Domain\TicketType\TicketTypeNotFoundException;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class UpdateTicketTypePriceCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly FlusherInterface              $flusher
    )
    {
    }

    public function __invoke(UpdateTicketTypePriceCommand $command)
    {
        $ticketType = $this->ticketTypeRepository->findById($command->ticketTypeId);
        if(!$ticketType){
            throw new TicketTypeNotFoundException($command->ticketTypeId);
        }
        $ticketType->changePrice($command->price);
        $this->flusher->flush();
    }
}