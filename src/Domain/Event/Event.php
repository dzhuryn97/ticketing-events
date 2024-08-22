<?php

namespace App\Domain\Event;

use App\Domain\Category\Category;
use App\Domain\Event\Exception\EventAlreadyCanceledException;
use App\Domain\Event\Exception\EventAlreadyStartedException;
use App\Domain\Event\Exception\EventEndDatePrecedesStartDateException;
use App\Domain\Event\Exception\EventNoDraftStatusException;
use Doctrine\ORM\Mapping as Mapping;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[Mapping\Entity(
    repositoryClass: EventRepositoryInterface::class
)]
class Event extends DomainEntity
{

    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid')]
    private UuidInterface $id;

    #[Mapping\ManyToOne(targetEntity: Category::class)]
    private Category $category;
    #[Mapping\Column]
    private string $title;
    #[Mapping\Column]
    private string $description;
    #[Mapping\Column]
    private string $location;
    #[Mapping\Column]
    private \DateTimeImmutable $startsAt;
    #[Mapping\Column]
    private ?\DateTimeImmutable $endsAt;
    #[Mapping\Column]
    private EventStatus $status;

    public function __construct(
        Category            $category,
        string              $title,
        string              $description,
        string              $location,
        \DateTimeImmutable  $startsAt,
        ?\DateTimeImmutable $endsAt,
    )
    {
        if ($endsAt && $endsAt < $startsAt) {
            throw new EventEndDatePrecedesStartDateException();
        }

        $this->id = UuidV4::uuid4();
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->status = EventStatus::Draft;

        $this->raiseDomainEvent(new EventCreatedDomainEvent($this->id));
    }

    public function publish(): void
    {
        if ($this->status !== EventStatus::Draft) {
//            throw new EventNoDraftStatusException();
        }

        if($this->status == EventStatus::Published){
            $this->status = EventStatus::Draft;
        } else {
            $this->status = EventStatus::Published;
        }
//        $this->status = EventStatus::Published;
        $this->raiseDomainEvent(new EventPublishedDomainEvent($this->id));
    }

    public function reschedule(
        \DateTimeImmutable  $startsAt,
        ?\DateTimeImmutable $endsAt,
    ): void
    {
        if ($this->startsAt === $startsAt && $this->endsAt === $endsAt){
            return;
        }

        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;

        $this->raiseDomainEvent(new EventRescheduledDomainEvent($this->id, $this->startsAt, $this->endsAt));
    }

    public function cancel(\DateTimeImmutable $now): void
    {
        if($this->status === EventStatus::Canceled){
            throw new EventAlreadyCanceledException();
        }

        if($this->startsAt < $now){
            throw new EventAlreadyStartedException();
        }

        $this->status = EventStatus::Canceled;
        $this->raiseDomainEvent(new EventCanceledDomainEvent($this->id));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getStartsAt(): \DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function getEndsAt(): ?\DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function getStatus(): EventStatus
    {
        return $this->status;
    }
}