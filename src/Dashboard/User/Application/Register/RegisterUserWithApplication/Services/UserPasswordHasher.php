<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithApplication\Services;

use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Agregate\UserHashedPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserPasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function __invoke(User $user, string $password): User
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword(new UserHashedPassword($hashedPassword));

        return $user;
    }
}
