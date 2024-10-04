<?php

namespace App\Application\Category\UpdateCategory;

use App\Domain\Category\CategoryRepositoryInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class UpdateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(UpdateCategoryCommand $command)
    {
        $category = $this->categoryRepository->findById($command->id);
        if (!$category) {
            throw new CategoryNotFoundException($command->id);
        }

        $category->update($command->name);

        $this->categoryRepository->save($category);
    }
}
