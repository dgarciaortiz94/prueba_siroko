<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithApplication;

use App\Shared\Domain\Bus\Command\ICommand;

class RegisterUserWithApplicationCommand implements ICommand
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $email,
        public string $password,
        public string $repeatedPassword,
        public ?string $secondSurname = null
    ) {
    }
}
