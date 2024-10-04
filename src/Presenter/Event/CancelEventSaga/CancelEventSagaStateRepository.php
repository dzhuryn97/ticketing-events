<?php

namespace App\Presenter\Event\CancelEventSaga;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CancelEventSagaStateRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CancelEventSagaState::class);
        $this->em = $this->getEntityManager();
    }

    public function createSagaState(UuidInterface $correlationId): void
    {
        $state = new CancelEventSagaState($correlationId, CancelEventSagaStateEnum::CANCELLATION_STARTED);
        $this->em->persist($state);
        $this->em->flush();
    }

    public function save(CancelEventSagaState $sagaState): void
    {
        $this->em->flush();
    }

    public function findByCorrelationId(UuidInterface $correlationId): ?CancelEventSagaState
    {
        return $this->find($correlationId);
    }
}
