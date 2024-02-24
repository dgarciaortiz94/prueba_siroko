<?php

namespace App\Dashboard\User\Application\SignIn\Shared;

class SignInProfileResponse
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $surname,
        public string $email,
        public array $roles,
        public ?string $secondSurname = null,
    ) {
    }
}
