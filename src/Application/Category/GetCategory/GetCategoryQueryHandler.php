<?php

namespace App\Application\Category\GetCategory;

use App\Domain\Category\CategoryRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

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
            throw new EntityNotFoundException();
        }

        return $category;
    }
}
