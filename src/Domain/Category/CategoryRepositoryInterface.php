<?php

namespace App\Domain\Category;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface CategoryRepositoryInterface
{
    public function add(Category $category): void;
    public function findById(UuidInterface $id):?Category;

    /**
     * @return Collection<Category>
     */
    public function all():array;
}