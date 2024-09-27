<?php

namespace App\Domain\Category\Exception;

use Ramsey\Uuid\UuidInterface;

class CategoryNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $id)
    {
        parent::__construct(sprintf('Category with identifier %s not found', $id));
    }
}
