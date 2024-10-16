<?php

namespace App\Presenter\Category;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\Category\Category;
use App\Presenter\Category\Processor\CreateCategoryProcessor;
use App\Presenter\Category\Processor\UpdateCategoryProcessor;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'category',
    operations: [
        new Get(
            security: "is_granted('ROLE_CATEGORY_VIEW')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_CATEGORY_VIEW')",
        ),
        new Post(
            denormalizationContext: [
                'groups' => ['category:create'],
            ],
            security: "is_granted('ROLE_CATEGORY_CREATE')",
            processor: CreateCategoryProcessor::class,
        ),
        new Put(
            denormalizationContext: [
                'groups' => ['category:update'],
            ],
            security: "is_granted('ROLE_CATEGORY_UPDATE')",
            processor: UpdateCategoryProcessor::class,
        ),
    ],
    paginationEnabled: false,
    provider: CategoryStateProvider::class,
)]
class CategoryResource
{
    #[Groups(['category:read'])]
    public ?UuidInterface $id = null;

    #[Assert\NotBlank]
    #[Groups(['category:create', 'category:update'])]
    public ?string $name = null;

    public static function fromCategory(Category $category): self
    {
        $categoryResource = new self();
        $categoryResource->id = $category->getId();
        $categoryResource->name = $category->getName();

        return $categoryResource;
    }
}
