<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithApplication;

use App\Dashboard\User\Application\Register\RegisterUserWithApplication\Services\UserPasswordHasher;
use App\Dashboard\User\Domain\Agregate\User;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class RegisterUserWithApplicationCommandHandler implements ICommandHandler
{
    public function __construct(
        private RegisterUserWithApplicationCase $registerUserCase,
        private UserPasswordHasher $passwordHasher
    ) {
    }

    public function __invoke(RegisterUserWithApplicationCommand $registerUserCommand): ICommandResponse
    {
        $user = User::register(
            $registerUserCommand->name,
            $registerUserCommand->surname,
            $registerUserCommand->email,
            $registerUserCommand->password,
            $registerUserCommand->repeatedPassword,
            $registerUserCommand->secondSurname,
        );

        $user = $this->passwordHasher->__invoke($user, $registerUserCommand->password);

        return $this->registerUserCase->__invoke($user);
    }
}
