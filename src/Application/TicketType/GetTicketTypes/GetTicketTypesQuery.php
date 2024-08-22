<?php

namespace App\Application\TicketType\GetTicketTypes;

use App\Domain\TicketType\TicketType;
use Ticketing\Common\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<TicketType[]>
 */
class GetTicketTypesQuery implements QueryInterface
{
    public function __construct(
    )
    {
    }
}