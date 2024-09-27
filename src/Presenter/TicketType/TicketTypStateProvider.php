<?php

namespace App\Presenter\TicketType;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\TicketType\GetTicketType\GetTicketTypeQuery;
use App\Application\TicketType\GetTicketTypes\GetTicketTypesQuery;
use App\Domain\TicketType\TicketType;
use Ticketing\Common\Application\Query\QueryBusInterface;

class TicketTypStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            $id = $uriVariables['id'];
            $ticketType = $this->queryBus->ask(
                new GetTicketTypeQuery($id)
            );

            return TicketTypeResource::fromTicketType($ticketType);
        }
        $ticketTypes = $this->queryBus->ask(
            new GetTicketTypesQuery()
        );

        return array_map(function (TicketType $ticketType) {
            return TicketTypeResource::fromTicketType($ticketType);
        }, $ticketTypes);
    }
}
