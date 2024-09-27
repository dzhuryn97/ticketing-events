<?php

namespace App\Tests\Unit\Domain\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryCreatedDomainEvent;
use App\Domain\Category\CategoryUpdatedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;

class CategoryTest extends AbstractTestCase
{
    #[Test]
    public function Create_ShouldRaiseDomainEvent_WhenCreated()
    {
        // Act
        $category = new Category(
            $this->faker->name()
        );

        // Assert
        $this->assertDomainEventRaised($category, CategoryCreatedDomainEvent::class);
    }

    #[Test]
    public function Create_ShouldRaiseDomainEvent_WhenUpdated()
    {
        // Arrange
        $category = new Category(
            $this->faker->name()
        );
        // Act
        $category->update($this->faker->name());

        // Assert
        $this->assertDomainEventRaised($category, CategoryUpdatedDomainEvent::class);
    }
}
