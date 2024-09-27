<?php

namespace App\Domain\TicketType;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;

interface TicketTypeRepositoryInterface
{
    public function findById(UuidInterface $ticketTypeId): ?TicketType;

    /**
     * @return array<TicketType>
     */
    public function getByEvent(Event $event): array;

    public function add(TicketType $ticketType): void;

    public function save(TicketType $ticketType): void;

    /**
     * @return array<TicketType>
     */
    public function all(): array;
}
