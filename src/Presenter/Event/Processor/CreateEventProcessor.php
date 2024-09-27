<?php

namespace App\Presenter\Event\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Event\CreateEvent\CreateEventCommand;
use App\Application\Event\GetEvent\GetEventQuery;
use App\Presenter\Event\EventResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class CreateEventProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @param EventResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $eventId = $this->commandBus->dispatch(
            new CreateEventCommand(
                $data->category->id,
                $data->title,
                $data->description,
                $data->location,
                $data->startsAt,
                $data->endsAt,
            )
        );

        $event = $this->queryBus->ask(new GetEventQuery($eventId));

        return EventResource::fromEvent($event);
    }
}
