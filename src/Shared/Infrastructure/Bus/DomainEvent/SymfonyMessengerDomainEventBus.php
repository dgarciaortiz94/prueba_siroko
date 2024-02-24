<?php

namespace App\Shared\Infrastructure\Bus\DomainEvent;

use App\Shared\Domain\Bus\DomainEvent\DomainEvent;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyMessengerDomainEventBus implements IDomainEventBus
{
    public function __construct(
        private MessageBusInterface $bus,
        private LoggerInterface $logger
    ) {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event)->last(HandledStamp::class)->getResult();
            } catch (HandlerFailedException $e) {
                while ($e instanceof HandlerFailedException) {
                    /** @var Throwable $e */
                    $e = $e->getPrevious();
                }

                $this->logger->error($e->getMessage());
            }
        }
    }
}
