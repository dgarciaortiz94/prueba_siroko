<?php

namespace App\Tests\Dashboard\User\Domain;

use App\Dashboard\User\Domain\Agregate\User;

class RegisterUserMother
{
    private User $user;

    private function __construct(
        string $name = 'Fake User',
        string $surname = 'Surname',
        string $email = 'mail@mail.com',
        string $plainPassword = '@Prueba123',
        string $repeatedPlainPassword = '@Prueba123',
        ?string $secondSurname = 'Second Surname',
    ) {
        $this->user = User::register(
            $name,
            $surname,
            $email,
            $plainPassword,
            $repeatedPlainPassword,
            $secondSurname
        );
    }

    public static function register(
        string $name = 'Fake User',
        string $surname = 'Surname',
        string $email = 'mail@mail.com',
        string $plainPassword = '@Prueba123',
        string $repeatedPlainPassword = '@Prueba123',
        ?string $secondSurname = 'Second Surname',
    ): User {
        $self = new self(
            $name,
            $surname,
            $email,
            $plainPassword,
            $repeatedPlainPassword,
            $secondSurname
        );

        return $self->user;
    }

    public static function registerWithGoogle(
        string $name = 'Fake User',
        string $surname = 'Surname',
        string $email = 'mail@gmail.com',
        string $plainPassword = '@Prueba123',
        string $repeatedPlainPassword = '@Prueba123',
        ?string $secondSurname = 'Second Surname',
    ): User {
        $user = User::registerWithGoogle(
            $name,
            $surname,
            $email,
            $plainPassword,
            $repeatedPlainPassword,
            $secondSurname,
        );

        return $user;
    }
}
