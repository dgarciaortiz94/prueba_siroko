<?php

namespace App\Shared\Domain\Services;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CurrentUserRecovery
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function __invoke(): ?UserInterface
    {
        return ($userToken = $this->tokenStorage->getToken()) ? $userToken : null;
    }
}
