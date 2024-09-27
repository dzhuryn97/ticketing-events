<?php

namespace App\Presenter\Category;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\Category\Category;
use App\Presenter\Category\Processor\CreateCategoryProcessor;
use App\Presenter\Category\Provider\GetCategoryStateProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'category',
    provider: GetCategoryStateProvider::class,
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            processor: CreateCategoryProcessor::class,
            denormalizationContext: [
                'groups' => ['category:create'],
            ]
        ),
        new Put(
            denormalizationContext: [
                'groups' => ['category:update'],
            ]
        ),
    ],
    paginationEnabled: false
)]
class CategoryResource
{
    #[Groups(['category:read'])]
    public UuidInterface $id;

    #[Assert\NotBlank]
    #[Groups(['category:create', 'category:update'])]
    public string $name;

    public static function fromCategory(Category $category): self
    {
        $categoryResource = new self();
        $categoryResource->id = $category->getId();
        $categoryResource->name = $category->getName();

        return $categoryResource;
    }
}
