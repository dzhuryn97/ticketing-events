<?php

namespace App\Application\TicketType\GetTicketType;

use App\Domain\TicketType\TicketTypeNotFoundException;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetTicketTypeQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository
    )
    {
    }

    public function __invoke(GetTicketTypeQuery $query)
    {
        $ticketType = $this->ticketTypeRepository->findById($query->ticketTypeId);
        if (!$ticketType) {
            throw new TicketTypeNotFoundException($query->ticketTypeId);
        }

        return $ticketType;
    }
}