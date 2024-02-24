<?php

namespace App\Dashboard\User\Application\Register\RegisterUserWithGoogle;

use App\Shared\Domain\Bus\Command\ICommand;

class RegisterUserWithGoogleCommand implements ICommand
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $email,
        public ?string $secondSurname = null
    ) {
    }
}
