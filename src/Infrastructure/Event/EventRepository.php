<?php

namespace App\Infrastructure\Event;

use App\Domain\Event\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Dto\PaginatedResults;

class EventRepository extends ServiceEntityRepository implements \App\Domain\Event\EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findById(UuidInterface $id): ?Event
    {
        return $this->find($id);
    }

    public function add(Event $event): void
    {
        $this->getEntityManager()->persist($event);
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function searchPaginated(?UuidInterface $categoryId, ?\DateTimeImmutable $startsAt, ?\DateTimeImmutable $endsAt, int $page, int $pageSize): PaginatedResults
    {

        $eQb = $this->createQueryBuilder('e');

        if ($categoryId) {
            $eQb->andWhere('e.category = :category');
            $eQb->setParameter('category', $categoryId);
        }
        if ($startsAt) {
            $eQb->andWhere($eQb->expr()->gte('e.startsAt', ':startsAt'));
            $eQb->setParameter('startsAt', $startsAt);
        }
        if ($endsAt) {
            $eQb->andWhere($eQb->expr()->lte('e.endsAt', ':endsAt'));
            $eQb->setParameter('endsAt', $endsAt);
        }

        //        foreach ($criteria as $property => $value) {
        //            $eQb->andWhere(sprintf('e.%s = :%s', $property, $property));
        //            $eQb->setParameter($property, $value);
        //        }

        return \Ticketing\Common\Infrastructure\ORM\Paginator::paginate($eQb, $page, $pageSize);
    }
}
