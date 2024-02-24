<?php

namespace App\Dashboard\User\Domain\TokenGenerator;

use App\Dashboard\User\Domain\Agregate\User;

interface ITokenGenerator
{
    public function generateToken(User $user): string;
}
