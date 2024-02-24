<?php

namespace App\Dashboard\User\Application\Register\Shared;

use App\Shared\Domain\Bus\Command\ICommandResponse;

class RegisterUserResponse implements ICommandResponse
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $surname,
        public string $email,
        public ?string $secondSurname = null,
    ) {
    }
}
