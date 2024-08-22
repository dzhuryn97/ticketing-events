<?php

namespace App\Application\Event\PublishEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class PublishEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $id
    )
    {
    }
}