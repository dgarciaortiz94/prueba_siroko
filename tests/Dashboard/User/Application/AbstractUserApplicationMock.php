<?php

namespace App\Tests\Dashboard\User\Application;

use App\Dashboard\User\Application\SignIn\SignInWithApplication\Services\UserPasswordChecker;
use App\Dashboard\User\Infrastructure\Persist\MysqlUserRepository;
use App\Shared\Infrastructure\Bus\DomainEvent\SymfonyMessengerDomainEventBus;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractUserApplicationMock extends WebTestCase
{
    protected MysqlUserRepository|MockObject|null $repository = null;
    protected SymfonyMessengerDomainEventBus|MockObject|null $eventBus = null;
    protected UserPasswordChecker|MockObject|null $userPasswordChecker = null;

    protected function repository(): MysqlUserRepository|MockObject
    {
        $repository = $this->getMockBuilder(MysqlUserRepository::class)->disableOriginalConstructor()->getMock();

        return $this->repository ??= $repository;
    }

    protected function eventBus(): SymfonyMessengerDomainEventBus|MockObject
    {
        $eventBus = $this->getMockBuilder(SymfonyMessengerDomainEventBus::class)->disableOriginalConstructor()->getMock();

        return $this->eventBus ??= $eventBus;
    }
}
