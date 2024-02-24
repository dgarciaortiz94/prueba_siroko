<?php

namespace App\Dashboard\User\Application\SignIn\SignInWithGoogle\Services;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SignInWithGoogleAuthenticator
{
    private \Google_Client $client;

    public function __construct(
        #[Autowire('%kernel.project_dir%/config')]
        private string $configDir,
    ) {
        $this->client = new \Google_Client([
            'client_id' => '94805569280-r8fq2t5nnnv05qqk9oh44q3qfu8hsip1.apps.googleusercontent.com',
        ]);  // Specify the CLIENT_ID of the app that accesses the backend
    }

    public function __invoke(?string $code, ?string $requestedWithHeader): array
    {
        $this->checkGoogleUserAuthenticationCode($code);
        $this->preventCsrfAttack($requestedWithHeader);

        $this->configGoogleClientAuthenticationRequest();

        return $this->authenticateUser($code);
    }

    private function authenticateUser(string $code): array
    {
        $googleOAuth2Response = $this->client->fetchAccessTokenWithAuthCode($code);

        $this->checkGoogleUserAuthentication($googleOAuth2Response);

        return $googleOAuth2Response;
    }

    private function configGoogleClientAuthenticationRequest(): void
    {
        $this->client->setAuthConfig($this->configDir.'/secret/google/client_secret.json');
        $this->client->setIncludeGrantedScopes(true);   // incremental auth
        $this->client->setAccessType('offline');        // offline access
        $this->client->setRedirectUri('postmessage');
    }

    private function checkGoogleUserAuthenticationCode(?string $code): void
    {
        if (!$code) {
            throw new UnauthorizedHttpException('Google user authentication code missing');
        }
    }

    private function preventCsrfAttack(?string $requestedWithHeader): void
    {
        if (is_null($requestedWithHeader) || ('XmlHttpRequest' != $requestedWithHeader)) {
            throw new UnauthorizedHttpException('CSRF request validation failed');
        }
    }

    private function checkGoogleUserAuthentication($googleOAuth2Response): void
    {
        if (isset($googleOAuth2Response['error'])) {
            throw new UnauthorizedHttpException('');
        }
    }
}
