<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithApplication;

use App\Dashboard\User\Application\SignIn\Exception\SignInWrongProviderException;
use App\Dashboard\User\Application\SignIn\Shared\SignInProfileResponse;
use App\Dashboard\User\Application\SignIn\Shared\SignInResponse;
use App\Dashboard\User\Application\SignIn\SignInWithApplication\Services\UserPasswordChecker;
use App\Dashboard\User\Application\SignIn\SignInWithApplication\Utils\SignInWithApplicationCredentials;
use App\Dashboard\User\Domain\Agregate\UserProvider;
use App\Dashboard\User\Domain\Services\UserFinderByEmail;
use App\Dashboard\User\Domain\TokenGenerator\ITokenGenerator;

class SignInWithApplicationCase
{
    public function __construct(
        private UserFinderByEmail $userFinderByEmail,
        private UserPasswordChecker $passwordChecker,
        private ITokenGenerator $tokenGenerator
    ) {
    }

    public function __invoke(SignInWithApplicationCredentials $credentials): SignInResponse
    {
        $user = $this->userFinderByEmail->__invoke($credentials->email());

        if (!$user->isApplicationProvider()) {
            throw new SignInWrongProviderException(UserProvider::APPLICATION);
        }

        $this->passwordChecker->__invoke($user, $credentials->password());

        $token = $this->tokenGenerator->generateToken($user);

        $response = new SignInResponse(
            new SignInProfileResponse(
                $user->getUserIdentifier(),
                $user->name(),
                $user->surname(),
                $user->email(),
                $user->getRoles(),
                $user->secondSurname(),
            ),
            $token
        );

        return $response;
    }
}
