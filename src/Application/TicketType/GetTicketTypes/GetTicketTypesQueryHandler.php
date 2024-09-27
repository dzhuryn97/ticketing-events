<?php

namespace App\Application\TicketType\GetTicketTypes;

use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetTicketTypesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
    ) {
    }

    public function __invoke(GetTicketTypesQuery $query)
    {
        return  $this->ticketTypeRepository->all();
    }
}
