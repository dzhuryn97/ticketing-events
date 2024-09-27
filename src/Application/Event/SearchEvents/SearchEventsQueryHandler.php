<?php

namespace App\Application\Event\SearchEvents;

use App\Domain\Event\EventRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class SearchEventsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
    ) {
    }

    public function __invoke(SearchEventsQuery $query)
    {
        return $this->eventRepository->searchPaginated(
            $query->categoryId,
            $query->startsAt,
            $query->endsAt,
            $query->page,
            $query->pageSize,
        );

    }
}
