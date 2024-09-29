<?php

namespace App\Domain\Category\Exception;

use App\Domain\Category\Category;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class CategoryNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $id)
    {
        parent::__construct($id, Category::class);
    }
}
