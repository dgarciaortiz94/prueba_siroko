<?php

namespace App\Shared\Domain\Bus\DomainEvent;

interface DomainEventSubscriber
{
    public static function suscribedTo(): array;
}
