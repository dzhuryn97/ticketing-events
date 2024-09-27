<?php

namespace App\Presenter\TicketType\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\TicketType\GetTicketType\GetTicketTypeQuery;
use App\Application\TicketType\UpdateTicketTypePrice\UpdateTicketTypePriceCommand;
use App\Presenter\TicketType\TicketTypeResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class UpdateTicketTypePriceProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @param TicketTypeResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $ticketTypeId = $uriVariables['id'];

        $this->commandBus->dispatch(
            new UpdateTicketTypePriceCommand(
                $ticketTypeId,
                $data->price,
            )
        );

        $ticketType = $this->queryBus->ask(
            new GetTicketTypeQuery($ticketTypeId)
        );

        return TicketTypeResource::fromTicketType($ticketType);
    }
}
