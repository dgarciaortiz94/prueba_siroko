<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithApplication;

use App\Dashboard\User\Application\Register\Shared\RegisterUserResponse;
use App\Dashboard\User\Application\Register\Shared\UserRegister;
use App\Dashboard\User\Domain\Agregate\User;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;

class RegisterUserWithApplicationCase
{
    public function __construct(
        private UserRegister $userRegister,
        private IDomainEventBus $domainEventBus
    ) {
    }

    public function __invoke(User $user): RegisterUserResponse
    {
        $user = $this->userRegister->__invoke($user);

        $this->domainEventBus->publish(...$user->pullDomainEvents());

        return new RegisterUserResponse(
            $user->getUserIdentifier(),
            $user->name(),
            $user->surname(),
            $user->email(),
            $user->secondSurname(),
        );
    }
}
