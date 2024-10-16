<?php

namespace App\Infrastructure\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Category $category): void
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function findById(UuidInterface $id): ?Category
    {
        return $this->find($id);
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function save(Category $category): void
    {
        $this->em->flush();
    }
}
