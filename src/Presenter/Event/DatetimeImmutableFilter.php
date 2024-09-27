<?php

namespace App\Presenter\Event;

use ApiPlatform\Api\FilterInterface;

class DatetimeImmutableFilter implements FilterInterface
{
    public function __construct(
        public readonly array $properties,
    ) {
    }

    public function getDescription(string $resourceClass): array
    {
        $description = [];
        foreach ($this->properties as $property => $config) {
            $description[$property] = [
                'property' => $property,
                'name' => 'mu na',
                'description' => 'Filter using datetime',
                'type' => 'string',
                'format' => 'date-time',

                'schema' => [
                    'format' => 'date-time',
                    'type' => 'integer',
                ],
            ];
        }

        return $description;
    }
}
