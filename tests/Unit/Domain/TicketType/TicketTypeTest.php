<?php

namespace App\Tests\Unit\Domain\TicketType;

use App\Domain\Category\Category;
use App\Domain\Event\Event;
use App\Domain\TicketType\TicketType;
use App\Domain\TicketType\TicketTypeCreatedDomainEvent;
use App\Domain\TicketType\TicketTypePriceChangedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;

class TicketTypeTest extends AbstractTestCase
{
    #[Test]
    public function Create_ShouldRaiseDomainEvent()
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
        $ticketType = new TicketType(
            $event,
            $this->faker->name(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit(),
        );

        // Assert
        $this->assertDomainEventRaised($ticketType, TicketTypeCreatedDomainEvent::class);
    }

    #[Test]
    public function ChangePrice_ShouldRaiseDomainEvent_WhenPriceChanged()
    {
        // Arrange
        $category = new Category($this->faker->name());
        $price = 100;
        $event = new Event(
            $category,
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $ticketType = new TicketType(
            $event,
            $this->faker->name(),
            $price,
            $this->faker->currencyCode(),
            $this->faker->randomDigit(),
        );

        // Act
        $newPrice = 200;
        $ticketType->changePrice($newPrice);

        // Assert
        $this->assertDomainEventRaised($ticketType, TicketTypePriceChangedDomainEvent::class);
    }

    #[Test]
    public function ChangePrice_ShouldNotRaiseDomainEvent_WhenPriceIsNotChanged()
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
        $ticketType = new TicketType(
            $event,
            $this->faker->name(),
            $price = $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit(),
        );
        $ticketType->clearDomainEvents();

        // Act
        $ticketType->changePrice($price);

        // Assert
        $this->assertCount(0, $ticketType->getDomainEvents());
    }
}
