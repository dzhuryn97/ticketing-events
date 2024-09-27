<?php

namespace App\Application\Event\CreateEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $categoryId,
        public readonly string $title,
        public readonly string $description,
        public readonly string $location,
        public readonly \DateTimeImmutable $startsAt,
        public readonly ?\DateTimeImmutable $endsAt,
    ) {
    }
}
