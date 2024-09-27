<?php

namespace App\Application\Category\GetCategory;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

class GetCategoryQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $id,
    ) {
    }
}
