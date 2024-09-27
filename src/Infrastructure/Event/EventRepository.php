<?php

namespace App\Infrastructure\Event;

use App\Domain\Event\Event;
use App\Domain\Event\EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Dto\PaginatedResults;
use Ticketing\Common\Infrastructure\ORM\Paginator;

class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $id): ?Event
    {
        return $this->find($id);
    }

    public function add(Event $event): void
    {
        $this->em->persist($event);
        $this->em->flush();
    }

    public function save(Event $event): void
    {
        $this->em->flush();
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


        return Paginator::paginate($eQb, $page, $pageSize);
    }
}
