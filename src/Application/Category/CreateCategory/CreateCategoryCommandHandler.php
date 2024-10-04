<?php

namespace App\Application\Category\CreateCategory;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(CreateCategoryCommand $command)
    {
        $category = new Category($command->name);

        $this->categoryRepository->add($category);

        return $category->getId();
    }
}
