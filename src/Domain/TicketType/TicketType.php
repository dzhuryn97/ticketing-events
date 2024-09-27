<?php

namespace App\Domain\TicketType;

use App\Domain\Event\Event;
use Doctrine\ORM\Mapping;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[Mapping\Entity(
    repositoryClass: TicketTypeRepositoryInterface::class
)]
class TicketType extends DomainEntity
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid')]
    private UuidInterface $id;

    #[Mapping\ManyToOne(targetEntity: Event::class)]
    private Event $event;

    #[Mapping\Column]
    private string $name;
    #[Mapping\Column]
    private float $price;
    #[Mapping\Column]
    private string $currency;
    #[Mapping\Column]
    private int $quantity;

    public function __construct(
        Event $event,
        string $name,
        float $price,
        string $currency,
        int $quantity,
    ) {
        $this->id = UuidV4::uuid4();
        $this->event = $event;
        $this->name = $name;
        $this->price = $price;
        $this->currency = $currency;
        $this->quantity = $quantity;

        $this->raiseDomainEvent(new TicketTypeCreatedDomainEvent($this->id));
    }

    public function changePrice(float $price): void
    {
        if ($price === $this->price) {
            return;
        }
        $this->price = $price;
        $this->raiseDomainEvent(new TicketTypePriceChangedDomainEvent($this->id));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
