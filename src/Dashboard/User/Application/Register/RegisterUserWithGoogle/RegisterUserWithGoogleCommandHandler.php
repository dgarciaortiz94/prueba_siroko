<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithGoogle;

use App\Dashboard\User\Domain\Agregate\User;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class RegisterUserWithGoogleCommandHandler implements ICommandHandler
{
    public function __construct(
        private RegisterUserWithGoogleCase $registerUserWithGoogleCase
    ) {
    }

    public function __invoke(RegisterUserWithGoogleCommand $registerUserWithGoogleCommand): ICommandResponse
    {
        $user = User::registerWithGoogle(
            $registerUserWithGoogleCommand->name,
            $registerUserWithGoogleCommand->surname,
            $registerUserWithGoogleCommand->email,
            $registerUserWithGoogleCommand->secondSurname,
        );

        return $this->registerUserWithGoogleCase->__invoke($user);
    }
}
