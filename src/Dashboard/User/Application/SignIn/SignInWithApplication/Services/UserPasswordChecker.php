<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithApplication\Services;

use App\Dashboard\User\Domain\Agregate\User;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordChecker
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $example = 1;
    }

    public function __invoke(User $user, string $password): bool
    {
        $passwordMatches = $this->passwordHasher->isPasswordValid($user, $password);

        $this->checkPasswordMatches($passwordMatches);

        return $password;
    }

    private function checkPasswordMatches(bool $passwordMatches): void
    {
        if (!$passwordMatches) {
            throw new InvalidPasswordException('Password is not correct');
        }
    }
}
