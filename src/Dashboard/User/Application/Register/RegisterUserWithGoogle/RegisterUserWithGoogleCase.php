<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithGoogle;

use App\Dashboard\User\Application\Register\Shared\RegisterUserResponse;
use App\Dashboard\User\Application\Register\Shared\UserRegister;
use App\Dashboard\User\Domain\Agregate\User;
use Symfony\Bundle\SecurityBundle\Security;

class RegisterUserWithGoogleCase
{
    public function __construct(
        private UserRegister $userRegister,
        private Security $security
    ) {
    }

    public function __invoke(User $user): RegisterUserResponse
    {
        $user = $this->userRegister->__invoke($user);

        return new RegisterUserResponse(
            $user->getUserIdentifier(),
            $user->name(),
            $user->surname(),
            $user->email(),
            $user->secondSurname(),
        );
    }
}
