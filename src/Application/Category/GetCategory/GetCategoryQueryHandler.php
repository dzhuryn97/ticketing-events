<?php

namespace App\Application\Category\GetCategory;

use App\Domain\Category\CategoryRepositoryInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetCategoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(GetCategoryQuery $query)
    {
        $category =  $this->categoryRepository->findById($query->id);
        if (!$category) {
            throw new CategoryNotFoundException($query->id);
        }

        return $category;
    }
}
