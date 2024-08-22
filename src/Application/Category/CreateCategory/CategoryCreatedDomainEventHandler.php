<?php

namespace App\Application\Category\CreateCategory;

use App\Domain\Category\CategoryCreatedDomainEvent;
use Ticketing\Common\Application\DomainEventHandlerInterface;

class CategoryCreatedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __invoke(CategoryCreatedDomainEvent $createCategoryCommandHandler)
    {
        dump('hello2');
    }
}