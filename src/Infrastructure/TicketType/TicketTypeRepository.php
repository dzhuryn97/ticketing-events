<?php

namespace App\Infrastructure\TicketType;

use App\Domain\Event\Event;
use App\Domain\TicketType\TicketType;
use App\Domain\TicketType\TicketTypeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class TicketTypeRepository extends ServiceEntityRepository implements TicketTypeRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketType::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $ticketTypeId): ?TicketType
    {
        return  $this->find($ticketTypeId);
    }

    public function add(TicketType $ticketType): void
    {
        $this->em->persist($ticketType);
        $this->em->flush();
    }

    public function save(TicketType $ticketType): void
    {
        $this->em->flush();
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function getByEvent(Event $event): array
    {
        return $this->findBy([
            'event' => $event,
        ]);
    }
}
