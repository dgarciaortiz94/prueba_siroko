<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithGoogle;

use App\Dashboard\Security\Application\GoogleUserAuthenticator\Services\GoogleTokenValidator;
use App\Dashboard\User\Application\Register\RegisterUserWithGoogle\RegisterUserWithGoogleCommand;
use App\Dashboard\User\Application\SignIn\Shared\SignInProfileResponse;
use App\Dashboard\User\Application\SignIn\Shared\SignInResponse;
use App\Dashboard\User\Application\SignIn\SignInWithGoogle\Services\SignInWithGoogleAuthenticator;
use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Services\UserFinderByEmail;
use Google\Service\PeopleService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class SignInWithGoogleCase
{
    public function __construct(
        private UserFinderByEmail $userFinderByEmail,
        private SignInWithGoogleAuthenticator $signInWithGoogleAuthenticator,
        private GoogleTokenValidator $tokenValidator,
        private MessageBusInterface $bus
    ) {
    }

    public function __invoke(string $code, string $requestedWithHeader): SignInResponse
    {
        $googleOAuth2Response = $this->signInWithGoogleAuthenticator->__invoke($code, $requestedWithHeader);

        $id_token = $googleOAuth2Response['id_token'];
        $access_token = $googleOAuth2Response['access_token'];
        $refresh_token = $googleOAuth2Response['refresh_token'];

        $payload = $this->tokenValidator->__invoke($id_token);

        try {
            $user = $this->findLoggedInUser($payload['email']);
        } catch (NotFoundHttpException $e) {
            $this->registerNonExistentUser($payload['email'], $access_token);

            $user = $this->findLoggedInUser($payload['email']);
        }

        return new SignInResponse(
            new SignInProfileResponse(
                $user->getUserIdentifier(),
                $user->name(),
                $user->surname(),
                $user->email(),
                $user->getRoles(),
                $user->secondSurname(),
            ),
            $id_token
        );
    }

    private function findLoggedInUser(string $userEmail): User
    {
        return $this->userFinderByEmail->__invoke($userEmail);
    }

    private function registerNonExistentUser(
        string $userEmail,
        string $access_token
    ): Envelope {
        try {
            $client = new \Google_Client();
            $client->setAccessToken($access_token);

            $peopleService = new PeopleService($client);
            $userInfo = $peopleService->people->get('people/me', [
                'personFields' => 'names,emailAddresses,photos,birthdays',
            ]);

            return $this->bus->dispatch(new RegisterUserWithGoogleCommand(
                $userInfo->getNames()[0]->getGivenName(),
                $userInfo->getNames()[0]->getFamilyName(),
                $userEmail,
            ));
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                /** @var Throwable $e */
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
