<?php

namespace App\Presenter\TicketType;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\TicketType\TicketType;
use App\Presenter\Event\EventResource;
use App\Presenter\TicketType\Processor\CreateTicketTypeProcessor;
use App\Presenter\TicketType\Processor\UpdateTicketTypePriceProcessor;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ticketType',
    operations: [
        new Get(
            security: "is_granted('ROLE_TICKET_TYPE_VIEW')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_TICKET_TYPE_VIEW')",
        ),
        new Post(
            denormalizationContext: [
                'groups' => [
                    'ticketType:create',
                ],
            ],
            security: "is_granted('ROLE_TICKET_TYPE_CREATE')",
            processor: CreateTicketTypeProcessor::class,
        ),
        new Put(
            uriTemplate: '/ticket_types/{id}/change_price',
            denormalizationContext: [
                'groups' => [
                    'ticketType:changePrice',
                ],
            ],
            security: "is_granted('ROLE_TICKET_TYPE_CHANGE_PRICE')",
            processor: UpdateTicketTypePriceProcessor::class,
        ),
    ],
    normalizationContext: [
        'groups' => [
            'ticketType:view',
        ],
    ],
    paginationEnabled: false,
    provider: TicketTypStateProvider::class
)]
class TicketTypeResource
{
    #[Groups(['ticketType:view'])]
    public UuidInterface $id;
    #[Groups(['ticketType:view', 'ticketType:create'])]
    public EventResource $event;
    #[Groups(['ticketType:view', 'ticketType:create'])]
    public string $name;
    #[Groups(['ticketType:view', 'ticketType:create', 'ticketType:changePrice'])]
    public float $price;
    #[Groups(['ticketType:view', 'ticketType:create'])]
    public string $currency;
    #[Groups(['ticketType:view', 'ticketType:create'])]
    public int $quantity;

    public static function fromTicketType(TicketType $ticketType): self
    {
        $ticketTypeResource = new self();
        $ticketTypeResource->id = $ticketType->getId();
        $ticketTypeResource->event = EventResource::fromEvent($ticketType->getEvent());
        $ticketTypeResource->name = $ticketType->getName();
        $ticketTypeResource->price = $ticketType->getPrice();
        $ticketTypeResource->currency = $ticketType->getCurrency();
        $ticketTypeResource->quantity = $ticketType->getQuantity();

        return $ticketTypeResource;
    }
}
