<?php

namespace App\Dashboard\User\Domain\Event;

use App\Shared\Domain\Bus\DomainEvent\DomainEvent;

class UserRegisteredEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private string $name,
        private string $surname,
        private string $secondSurname,
        private array $roles,
        private string $email,
        private string $provider,
        private string $createdAt,
    ) {
        parent::__construct($id);
    }

    public static function eventName(): string
    {
        return 'user.registered';
    }
}
