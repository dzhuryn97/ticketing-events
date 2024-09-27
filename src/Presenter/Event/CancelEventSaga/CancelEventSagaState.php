<?php

namespace App\Presenter\Event\CancelEventSaga;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping;
use Ramsey\Uuid\UuidInterface;

#[Entity(
    repositoryClass: CancelEventSagaRepository::class
)]
class CancelEventSagaState
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid')]
    public UuidInterface $correlationId;
    #[Mapping\Column]
    private CancelEventSagaStateEnum $state;

    public function __construct(
        UuidInterface $correlationId,
        CancelEventSagaStateEnum $state,
    ) {
        $this->correlationId = $correlationId;
        $this->state = $state;
    }

    public function updateCurrentState(CancelEventSagaStateEnum $state): void
    {
        $this->state = $state;
    }

    public function getCurrentState(): CancelEventSagaStateEnum
    {
        return $this->state;
    }
}
