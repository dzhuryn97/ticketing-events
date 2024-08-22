<?php

namespace App\Application\Category\UpdateCategory;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class UpdateCategoryCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
    )
    {
    }
}