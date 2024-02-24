<?php

namespace App\Shared\Domain\Bus\DomainEvent;

interface IDomainEventBus
{
    public function publish(DomainEvent ...$events): void;
}
