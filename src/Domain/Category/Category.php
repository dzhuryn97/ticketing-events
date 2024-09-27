<?php

namespace App\Domain\Category;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[ORM\Entity(repositoryClass: CategoryRepositoryInterface::class)]
class Category extends DomainEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: '50')]
    private string $name;

    public function __construct(
        string $name,
    ) {
        $this->id = UuidV4::uuid4();
        $this->name = $name;

        $this->raiseDomainEvent(new CategoryCreatedDomainEvent($this->id));
    }

    public function update(
        string $name,
    ): void {
        $this->name = $name;
        $this->raiseDomainEvent(new CategoryUpdatedDomainEvent($this->id));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
