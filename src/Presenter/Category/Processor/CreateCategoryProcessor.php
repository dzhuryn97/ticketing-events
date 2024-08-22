<?php

namespace App\Presenter\Category\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Category\CreateCategory\CreateCategoryCommand;
use App\Application\Category\GetCategory\GetCategoryQuery;
use App\Presenter\Category\CategoryResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class CreateCategoryProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    )
    {
    }

    /**
     * @param CategoryResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $categoryId =$this->commandBus->dispatch(new CreateCategoryCommand(
            $data->name
        ));

        $category = $this->queryBus->ask(new GetCategoryQuery($categoryId));

        return CategoryResource::fromCategory($category);
    }
}