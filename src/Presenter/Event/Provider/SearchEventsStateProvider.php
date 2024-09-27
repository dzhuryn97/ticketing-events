<?php

namespace App\Presenter\Event\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Application\Event\SearchEvents\SearchEventsQuery;
use App\Domain\Event\Event;
use App\Presenter\Event\EventResource;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ticketing\Common\Application\Query\QueryBusInterface;

class SearchEventsStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $pageSize = 15;
        $filters = $context['filters'] ?? [];
        $page = $filters['page'] ?? 1;

        $result = $this->queryBus->ask(
            new SearchEventsQuery(
                isset($filters['categoryId']) ? UuidV4::fromString($filters['categoryId']) : null,
                isset($filters['startsAt']) ? new \DateTimeImmutable($filters['startsAt']) : null,
                isset($filters['endsAt']) ? new \DateTimeImmutable($filters['endsAt']) : null,
                $page,
                $pageSize,
            )
        );

        $eventResources = $this->transformToEventResources($result->data);

        return new TraversablePaginator(
            $eventResources,
            $result->currentPage,
            $result->pageSize,
            $result->totalItems
        );
    }

    private function transformToEventResources(array $data)
    {
        return  new ArrayCollection(
            array_map(function (Event $event) {
                return EventResource::fromEvent($event);
            }, $data)
        );
    }
}
