<?php

namespace App\Presenter\Event\CancelEventSaga;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CancelEventSagaRepository extends ServiceEntityRepository
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CancelEventSagaState::class);
        $this->em = $this->getEntityManager();
    }

    public function createSagaState(UuidInterface $correlationId)
    {
        $state = new CancelEventSagaState($correlationId, CancelEventSagaStateEnum::CANCELLATION_STARTED);
        $this->em->persist($state);
    }

    public function findByCorrelationId(UuidInterface $correlationId): ?CancelEventSagaState
    {
        return $this->find($correlationId);
    }
}
