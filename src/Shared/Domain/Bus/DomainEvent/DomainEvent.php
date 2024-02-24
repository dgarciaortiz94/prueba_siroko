<?php

namespace App\Shared\Domain\Bus\DomainEvent;

use Symfony\Component\Uid\Uuid;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(
        private readonly string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        $this->eventId = $eventId ?? Uuid::v4();
        $this->occurredOn = $occurredOn ?? (new \DateTimeImmutable())->format('Y/m/d h:i:s');
    }

    abstract public static function eventName(): string;

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
