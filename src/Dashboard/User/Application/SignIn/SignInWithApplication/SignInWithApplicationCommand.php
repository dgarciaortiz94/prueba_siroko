<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithApplication;

use App\Shared\Domain\Bus\Command\ICommand;

class SignInWithApplicationCommand implements ICommand
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
