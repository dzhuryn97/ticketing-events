<?php

namespace App\Presenter\Category\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Presenter\Category\CategoryResource;
use Ticketing\Common\Application\Command\CommandBusInterface;

class UpdateCategoryProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    /**
     * @param CategoryResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // TODO: Implement process() method.
    }
}