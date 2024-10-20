<?php

namespace App\Presenter\Event;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\QueryParameter;
use App\Domain\Event\Event;
use App\Presenter\Category\CategoryResource;
use App\Presenter\Event\Processor\CancelEventProcessor;
use App\Presenter\Event\Processor\CreateEventProcessor;
use App\Presenter\Event\Processor\PublishEventProcessor;
use App\Presenter\Event\Processor\RescheduleEventProcessor;
use App\Presenter\Event\Provider\EventStateProvider;
use App\Presenter\Event\Provider\SearchEventsStateProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'event',
    operations: [
        new Get(
            security: "is_granted('ROLE_EVENT_VIEW')",
        ),
        new GetCollection(
            uriTemplate: '/events/search',
            security: "is_granted('ROLE_EVENT_VIEW')",
            provider: SearchEventsStateProvider::class,
            parameters: [
                'categoryId' => new QueryParameter(
                    schema: [
                        'type' => 'string',
                        'format' => 'uuid',
                    ],
                ),
            ],
        ),
        new Post(
            denormalizationContext: [
                'groups' => [
                    'event:create',
                ],
            ],
            security: "is_granted('ROLE_EVENT_CREATE')",
            processor: CreateEventProcessor::class,
        ),
        new Put(
            uriTemplate: '/events/{id}/publish',
            denormalizationContext: [
                'groups' => ['event:publish'],
            ],
            security: "is_granted('ROLE_EVENT_PUBLISH')",
            processor: PublishEventProcessor::class,
        ),

        new Put(
            uriTemplate: '/events/{id}/cancel',
            denormalizationContext: [
                'groups' => ['event:cancel'],
            ],
            security: "is_granted('ROLE_EVENT_CANCEL')",
            processor: CancelEventProcessor::class,
        ),

        new Patch(
            uriTemplate: '/events/{id}/reschedule',
            denormalizationContext: [
                'groups' => ['event:reschedule'],
            ],
            security: "is_granted('ROLE_EVENT_RESCHEDULE')",
            processor: RescheduleEventProcessor::class,
        ),
    ],
    provider: EventStateProvider::class
)]
#[ApiFilter(filterClass: DatetimeImmutableFilter::class, properties: ['startsAt', 'endsAt'])]
class EventResource
{
    public UuidInterface $id;

    #[Groups(['event:create', 'event:read'])]
    public CategoryResource $category;
    #[Groups(['event:create', 'event:read'])]
    public string $title;
    #[Groups(['event:create', 'event:read'])]
    public string $description;
    #[Groups(['event:create', 'event:read'])]
    public string $location;
    #[Groups(['event:create', 'event:read', 'event:reschedule'])]
    public \DateTimeImmutable $startsAt;
    #[Groups(['event:create', 'event:read', 'event:reschedule'])]
    public ?\DateTimeImmutable $endsAt;

    public static function fromEvent(Event $event): self
    {
        $eventResource = new self();

        $eventResource->id = $event->getId();
        $eventResource->category = CategoryResource::fromCategory($event->getCategory());
        $eventResource->title = $event->getTitle();
        $eventResource->description = $event->getDescription();
        $eventResource->location = $event->getLocation();
        $eventResource->startsAt = $event->getStartsAt();
        $eventResource->endsAt = $event->getEndsAt();

        return $eventResource;
    }
}
