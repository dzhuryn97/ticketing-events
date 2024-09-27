<?php

namespace App\Application\Category\CreateCategory;

use Ticketing\Common\Application\Command\CommandInterface;

class CreateCategoryCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}
