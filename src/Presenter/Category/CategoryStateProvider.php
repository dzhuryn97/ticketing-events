<?php

namespace App\Presenter\Category;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Category\GetCategories\GetCategoriesQuery;
use App\Application\Category\GetCategory\GetCategoryQuery;
use App\Domain\Category\Category;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class CategoryStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            return $this->getCategory($uriVariables['id']);
        }

        return $this->getCategories();
    }

    private function getCategory(UuidInterface $id): CategoryResource
    {
        $category = $this->queryBus->ask(
            new GetCategoryQuery($id)
        );

        return CategoryResource::fromCategory($category);
    }

    /**
     * @return CategoryResource[]
     */
    private function getCategories(): array
    {
        $categories = $this->queryBus->ask(
            new GetCategoriesQuery()
        );

        return  array_map(function (Category $category) {
            return CategoryResource::fromCategory($category);
        }, $categories);
    }
}
