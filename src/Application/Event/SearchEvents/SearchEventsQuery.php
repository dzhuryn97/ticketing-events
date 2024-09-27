<?php

namespace App\Application\Event\SearchEvents;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;
use Ticketing\Common\Domain\Dto\PaginatedResults;

/**
 * @implements QueryInterface<PaginatedResults<Event>>
 */
class SearchEventsQuery implements QueryInterface
{
    public function __construct(
        public readonly ?UuidInterface $categoryId,
        public readonly ?\DateTimeImmutable $startsAt,
        public readonly ?\DateTimeImmutable $endsAt,
        public readonly int $page,
        public readonly int $pageSize,
    ) {
    }
}
