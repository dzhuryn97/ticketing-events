<?php

namespace App\Presenter\Event\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Event\GetEvent\GetEventQuery;
use App\Presenter\Event\EventResource;
use Ticketing\Common\Application\Query\QueryBusInterface;

class GetEventStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $eventId = $uriVariables['id'];
        $event = $this->queryBus->ask(
            new GetEventQuery($eventId)
        );

        return EventResource::fromEvent($event);
    }
}