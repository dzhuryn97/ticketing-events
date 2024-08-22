<?php

namespace App\Presenter\Category\Provider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Category\GetCategories\GetCategoriesQuery;
use App\Application\Category\GetCategory\GetCategoryQuery;
use App\Domain\Category\Category;
use App\Presenter\Category\CategoryResource;
use Ticketing\Common\Application\Query\QueryBusInterface;

class GetCategoryStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if($operation instanceof Get){
            $id = $uriVariables['id'];

            $category = $this->queryBus->ask(
                new GetCategoryQuery($id)
            );

            return CategoryResource::fromCategory($category);
        }

        $categories =$this->queryBus->ask(
            new GetCategoriesQuery()
        );

        return  array_map(function (Category $category){
            return CategoryResource::fromCategory($category);
        }, $categories);
    }
}