<?php

namespace App\Application\Category\GetCategories;

use App\Domain\Category\CategoryRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetCategoriesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(GetCategoriesQuery $query)
    {
        return $this->categoryRepository->all();
    }
}
