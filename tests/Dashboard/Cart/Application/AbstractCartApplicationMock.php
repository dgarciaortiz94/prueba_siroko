<?php

namespace App\Tests\Dashboard\Cart\Application;

use App\Dashboard\Cart\Infrastructure\Persist\MysqlCartRepository;
use App\Shared\Infrastructure\Bus\DomainEvent\SymfonyMessengerDomainEventBus;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractCartApplicationMock extends WebTestCase
{
    protected MysqlCartRepository|MockObject|null $repository = null;
    protected SymfonyMessengerDomainEventBus|MockObject|null $eventBus = null;

    protected function repository(): MysqlCartRepository|MockObject
    {
        $repository = $this->getMockBuilder(MysqlCartRepository::class)->disableOriginalConstructor()->getMock();

        return $this->repository ??= $repository;
    }

    protected function eventBus(): SymfonyMessengerDomainEventBus|MockObject
    {
        $eventBus = $this->getMockBuilder(SymfonyMessengerDomainEventBus::class)->disableOriginalConstructor()->getMock();

        return $this->eventBus ??= $eventBus;
    }
}
