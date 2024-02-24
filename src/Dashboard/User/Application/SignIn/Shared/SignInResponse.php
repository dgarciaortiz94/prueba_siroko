<?php

namespace App\Dashboard\User\Application\SignIn\Shared;

use App\Shared\Domain\Bus\Command\ICommandResponse;

class SignInResponse implements ICommandResponse
{
    public function __construct(
        public SignInProfileResponse $profile,
        public string $token,
    ) {
    }
}
