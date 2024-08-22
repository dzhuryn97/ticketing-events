<?php

namespace App\Domain\TicketType;

use App\Domain\Event\Event;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface TicketTypeRepositoryInterface
{
    public function findById(UuidInterface $ticketTypeId):?TicketType;

    /**
     * @return array<TicketType>
     */
    public function getByEvent(Event $event):array;

    public function add(TicketType $ticketType): void;

    /**
     * @return array<TicketType>
     */
    public function all();


}