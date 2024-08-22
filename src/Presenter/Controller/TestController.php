<?php

namespace App\Presenter\Controller;

use App\Application\Event\PublishEvent\EventPublishedDomainEventHandler;
use App\Domain\Event\EventCanceledDomainEvent;
use App\Domain\Event\EventPublishedDomainEvent;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Infrastructure\Inbox\InboxMessageStorage;
use Ticketing\Common\Infrastructure\Inbox\IntegrationEventMessageHandler;
use Ticketing\Common\IntegrationEvent\Ticket\EventPaymentsRefundedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Ticket\EventTicketsArchivedIntegrationEvent;

class TestController extends AbstractController
{
    #[Route('/api/events/test')]
    public function index(
        MessageBusInterface              $commonOutboxMessageBus,
        IntegrationEventMessageHandler   $handler,
        MessageBusInterface              $messageBus,
        Connection                       $connection,
        SerializerInterface              $serializer,
        InboxMessageStorage              $inboxMessageStorage,
        CacheInterface                   $myCachePool,
        CommandBusInterface              $commandBus,
        EventPublishedDomainEventHandler $eventPublishedDomainEventHandler,
        Stopwatch                        $stopwatch,

    )
    {

        $eventId = UuidV4::fromString('561eff75-8dc7-433b-ada7-52b0f53e5b39');

//        $messageBus->dispatch(
//            new EventTicketsArchivedIntegrationEvent(
//                UuidV4::uuid4(),
//                new \DateTimeImmutable(),
//                $eventId
//            )
//        );


//        $messageBus->dispatch(
//            new EventPaymentsRefundedIntegrationEvent(
//                UuidV4::uuid4(),
//                new \DateTimeImmutable(),
//                $eventId
//            )
//        );

        dd('ready');



        $stopwatch->openSection();
        sleep(1);
        $stopwatch->start('validating-file', 'validation');
        sleep(1);
        $stopwatch->stopSection('parsing');
        sleep(1);

        $events = $stopwatch->getSectionEvents('parsing');

// later you can reopen a section passing its name to the openSection() method
        sleep(1);
        $stopwatch->openSection('parsing');
        sleep(1);
        $stopwatch->start('processing-file');
        sleep(1);
        $stopwatch->stopSection('parsing');
        sleep(1);

//        $stopwatch->start('export-init', 'export');
//
//        foreach ([1, 2, 3] as $item) {
//            sleep(rand(1,2));
//            $stopwatch->lap('export-init');
//        }
//
//
//        $stopwatch->stop('export-init');

//        $stopwatch->start('export-data', 'export');
//        sleep(1);
//        $stopwatch->stop('export-data');

        $eventId = UuidV4::fromString('a5b1694e-d174-4ecd-b978-30016a6f3140');
        $domainEvent = new EventPublishedDomainEvent($eventId);
        $eventPublishedDomainEventHandler($domainEvent);

//        $commandBus->dispatch(
//            new PublishEventCommand(
//                UuidV4::fromString('a5b1694e-d174-4ecd-b978-30016a6f3140')
//            )
//        );
//        $result = $myCachePool->get('test2', function (ItemInterface $item){
////            $expitedAt =new \DateTimeImmutable('+15s');
//            dump('render');
//            dd(new \DateTimeImmutable('+15s'));
//         $item->expiresAt(new \DateTimeImmutable('+15s'));
//            return '15';
//        });
//
//        dump($result);
//        dd('end');
//        return $this->json(true);
//        dd($myCachePool);

//        $integrationsEvent = new EventPublishedIntegrationEvent(UuidV4::fromString('5cf89cbe-27d4-4493-962f-de4dd171363a'));
//        $inboxMessage = InboxMessage::fromIntegrationEvent($integrationsEvent);
//        $inboxMessageStorage->send($inboxMessage);


//        $integrationsEvent = new EventPublishedIntegrationEvent(UuidV4::fromString('5cf89cbe-27d4-4493-962f-de4dd171363a'));
//
//                $inboxMessage = new InboxMessage();
//        $inboxMessage->inboxMessageId = $integrationsEvent->id;
//        $inboxMessage->occurredOn = $integrationsEvent->occurredOn;
//        $inboxMessage->integrationsEvent = $integrationsEvent;
//        $body = serialize($inboxMessage);

//        $integrationsEvent->id = UuidV4::fromString('5cf89cbe-27d4-4493-962f-de4dd171363a');


//        $messageBus->dispatch($inboxMessage);
//
//
//        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
//        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);
//
//        $serializer = new Serializer(
//            [new ObjectNormalizer($classMetadataFactory, null, null, null, $discriminator)],
//            ['json' => new JsonEncoder()]
//        );
//
//
//        $data = $serializer->serialize($event,'json');
//        dd($data);

//
//        echo 'start.'.(new \DateTimeImmutable())->format('h:i:s')."<br>";
//
//
//        $connection->beginTransaction();
//        $qb = $connection->createQueryBuilder()
//            ->select('*')
//            ->from('test')
//            ->forUpdate(ConflictResolutionMode::ORDINARY)
////            ->executeQuery()
////            ->fetchAssociative()
//        ->orderBy('id','asc')
//            ;
//
//        $result = $qb
//            ->setMaxResults(2)
//            ->executeQuery()
//            ->fetchAssociative()
//            ;
//
//
//
//        $qb = $connection->createQueryBuilder()
//            ->select('*')
//            ->from('test')
//            ->forUpdate(ConflictResolutionMode::ORDINARY)
////            ->executeQuery()
////            ->fetchAssociative()
//            ->orderBy('id','asc')
//        ;
//
//        $result = $qb
//            ->setMaxResults(2)
//            ->executeQuery()
//            ->fetchAssociative()
//        ;
//
//
//
//
////        dump($result);
//
//        $id = $result['id'];
//        $storage = $result['storage'];
////
//        sleep(2);
////        dump($result);
////
//        $newValue = $storage+1;
//        $connection->createQueryBuilder()
//            ->update('test')
//            ->set('storage', $newValue)
//            ->where('id = ?')
//            ->setParameter(0,$id)
//            ->executeQuery()
//        ;
//        $connection->commit();
////
//        echo 'end.'.(new \DateTimeImmutable())->format('h:i:s')."<br>";
//        dump($newValue);
//        $messageBus->dispatch(new TestMessage());
//        return $this->json(true);
//        $event = new EventPublishedIntegrationEvent(UuidV4::uuid4());
//        $handler($event);
//        $messageBus->dispatch($event);
//        $commandBus->dispatch(
//            new CreateCategoryCommand(
//                'hello'
//            )
//        );
//        $categories = $queryBus->ask(new GetCategoriesQuery());


//        $commandBus2->handle();
//        dd($categories);
//        $testComplex->handle();
//        $testService->run();;


//        $connection->createSchemaManager();
//        $messageBus->publish(new EventPublishedIntegrationEvent());
//        $commonOutboxMessageBus->dispatch(new OutboxMessage(new CategoryCreatedDomainEvent(UuidV4::uuid4())));
//        $category = new Category(
//            'test - '.time()
//        );
//        $categoryRepository->add($category);
//        $flusher->flush();

//        $eventDispatcher->dispatch(new CategoryCreatedDomainEvent(UuidV4::uuid4()));

//        $eventBus->dispatch(new CategoryCreatedDomainEvent(UuidV4::uuid4()));
//        $categories = $queryBus->ask(new GetCategoriesQuery());
//        dd($categories);
//        $commandBus->dispatch(new CreateCategoryCommand('Test'));
//        dd($commandBus);

        return $this->json(true);
    }
}