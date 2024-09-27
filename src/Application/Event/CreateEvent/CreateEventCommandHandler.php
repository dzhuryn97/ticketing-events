<?php

namespace App\Application\Event\CreateEvent;

use App\Domain\Category\CategoryRepositoryInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Event\Event;
use App\Domain\Event\EventRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class CreateEventCommandHandler implements CommandHandlerInterface
{
    private CategoryRepositoryInterface $categoryRepository;
    private EventRepositoryInterface $eventRepository;
    private FlusherInterface $flusher;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        EventRepositoryInterface $eventRepository,
        FlusherInterface $flusher,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
        $this->flusher = $flusher;
    }

    public function __invoke(CreateEventCommand $command)
    {
        $category = $this->categoryRepository->findById($command->categoryId);
        if (!$category) {
            throw new CategoryNotFoundException($command->categoryId);
        }

        $event = new Event(
            $category,
            $command->title,
            $command->description,
            $command->location,
            $command->startsAt,
            $command->endsAt,
        );
        $this->eventRepository->add($event);
        $this->flusher->flush();

        return $event->getId();
    }
}
