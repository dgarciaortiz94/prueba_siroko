<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithApplication\Utils;

use App\Dashboard\User\Domain\Agregate\UserEmail;
use App\Dashboard\User\Domain\Agregate\UserPlainPassword;

class SignInWithApplicationCredentials
{
    private UserEmail $email;

    private UserPlainPassword $password;

    private function __construct()
    {
    }

    public static function create(
        string $email,
        string $password
    ): self {
        $self = new self();

        $self->email = new UserEmail($email);
        $self->password = new UserPlainPassword($password);

        return $self;
    }

    public function email(): string
    {
        return $this->email->value();
    }

    public function password(): string
    {
        return $this->password->value();
    }
}
