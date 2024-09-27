<?php

namespace App\Domain\Category;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class CategoryUpdatedDomainEvent extends DomainEvent
{
    public readonly UuidInterface $categoryId;

    public function __construct(
        UuidInterface $categoryId,
    ) {
        $this->categoryId = $categoryId;
        parent::__construct();
    }
}
