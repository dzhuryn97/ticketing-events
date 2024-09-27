<?php

namespace App\Domain\Event;

use App\Domain\Category\Category;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Dto\PaginatedResults;

interface EventRepositoryInterface
{
    public function findById(UuidInterface $id): ?Event;

    /**
     * @return array<Event>
     */
    public function all(): array;

    public function add(Event $event): void;

    public function save(Event $event): void;

    /**
     * @return PaginatedResults<Category>
     */
    public function searchPaginated(
        ?UuidInterface $categoryId,
        ?\DateTimeImmutable $startsAt,
        ?\DateTimeImmutable $endsAt,
        int $page,
        int $pageSize,
    ): PaginatedResults;
}
