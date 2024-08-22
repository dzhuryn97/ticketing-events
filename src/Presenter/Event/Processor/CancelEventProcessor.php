<?php

namespace App\Presenter\Event\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Event\CancelEvent\CancelEventCommand;
use App\Application\Event\GetEvent\GetEventQuery;
use App\Presenter\Event\EventResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class CancelEventProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $id = $uriVariables['id'];
        $this->commandBus->dispatch(
            new CancelEventCommand($id)
        );

        $event = $this->queryBus->ask(
            new GetEventQuery($id)
        );

        return EventResource::fromEvent($event);
    }
}