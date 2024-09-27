<?php

namespace App\Tests\Unit\Domain\Event;

use App\Domain\Category\Category;
use App\Domain\Event\Event;
use App\Domain\Event\EventCanceledDomainEvent;
use App\Domain\Event\EventRescheduledDomainEvent;
use App\Domain\Event\EventStatus;
use App\Domain\Event\Exception\EventAlreadyCanceledException;
use App\Domain\Event\Exception\EventAlreadyStartedException;
use App\Domain\Event\Exception\EventEndDatePrecedesStartDateException;
use App\Domain\Event\Exception\EventNoDraftStatusException;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;

class EventTest extends AbstractTestCase
{
    #[Test]
    public function Create_ShouldFail_WhenEndDatePrecedesStartDate()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $startsAt = new \DateTimeImmutable();
        $endsAt = new \DateTimeImmutable('-1 minute');

        // Assert
        $this->expectException(EventEndDatePrecedesStartDateException::class);

        // Act
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            $startsAt,
            $endsAt
        );
    }

    #[Test]
    public function Publish_ShouldFail_WhenPublishNotDraft()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $event->publish();

        // Act
        $this->expectException(EventNoDraftStatusException::class);
        $event->publish();
    }

    #[Test]
    public function Publish_ShouldChangeStatus_WhenPublished()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        // Act
        $event->publish();

        // Act
        $this->assertEquals(EventStatus::Published, $event->getStatus());
    }

    #[Test]
    public function Cancel_ShouldFail_WhenIsCanceled()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $event->cancel(new \DateTimeImmutable('-1 minute'));

        $this->expectException(EventAlreadyCanceledException::class);
        $event->cancel(new \DateTimeImmutable());
    }

    #[Test]
    public function Cancel_ShouldFail_WhenAlreadyStarted()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        $this->expectException(EventAlreadyStartedException::class);
        $event->cancel(new \DateTimeImmutable('+1 minute'));
    }

    #[Test]
    public function Cancel_ShouldSuccess_WhenCanceled()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        // Act
        $event->cancel(new \DateTimeImmutable('-1 minute'));

        // Assert
        $this->assertDomainEventRaised($event, EventCanceledDomainEvent::class);
        $this->assertEquals(EventStatus::Canceled, $event->getStatus());
    }

    #[Test]
    public function Reschedule_ShouldRaiseDomainEvent_WhenDateChanged()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        // Act
        $event->reschedule(
            new \DateTimeImmutable('+1 minute'),
            new \DateTimeImmutable('+1 minute'),
        );

        // Assert
        $this->assertDomainEventRaised($event, EventRescheduledDomainEvent::class);
    }

    #[Test]
    public function Reschedule_ShouldNotRaiseDomainEvent_WhenDateNotChanged()
    {
        $format = 'Y-m-d H:i:s';
        $startsAt = (new \DateTimeImmutable())->format($format);
        $endsAt = (new \DateTimeImmutable())->format($format);

        // Arrange
        $category = new Category($this->faker->name());
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            \DateTimeImmutable::createFromFormat($format, $startsAt),
            \DateTimeImmutable::createFromFormat($format, $endsAt),
        );
        $event->clearDomainEvents();

        // Act
        $event->reschedule(
            \DateTimeImmutable::createFromFormat($format, $startsAt),
            \DateTimeImmutable::createFromFormat($format, $endsAt),
        );

        // Assert
        $this->assertCount(0, $event->getDomainEvents());
    }
}
