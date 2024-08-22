<?php

namespace App\Application\Category\CreateCategory;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepositoryInterface;
use Ticketing\Common\Application\FlusherInterface;


class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly FlusherInterface                     $flusher
    )
    {
    }

    public function __invoke(CreateCategoryCommand $command)
    {
        $category = new Category($command->name);
        $this->categoryRepository->add($category);
        $this->flusher->flush();

        return $category->getId();
    }
}