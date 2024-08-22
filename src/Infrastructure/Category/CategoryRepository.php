<?php

namespace App\Infrastructure\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{

    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Category $category): void
    {
        $this->em->persist($category);
    }

    public function findById(UuidInterface $id): ?Category
    {
        return $this->find($id);
    }

    public function all(): array
    {
        return $this->findAll();
    }
}