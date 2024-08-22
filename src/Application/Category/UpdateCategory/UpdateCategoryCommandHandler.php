<?php

namespace App\Application\Category\UpdateCategory;

use App\Domain\Category\CategoryRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class UpdateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly FlusherInterface                     $flusher
    )
    {
    }

    public function __invoke(UpdateCategoryCommand $command)
    {
        $category = $this->categoryRepository->findById($command->id);

        if (!$category) {
            throw new EntityNotFoundException();
        }

        $category->update($command->name);
        $this->flusher->flush();
    }
}