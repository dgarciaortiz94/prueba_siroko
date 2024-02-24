<?php

namespace App\Entrypoint\Controller\Dashboard\Authentication;

use App\Dashboard\User\Application\SignIn\SignInWithGoogle\SignInWithGoogleCommand;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GoogleSignInController extends BaseController
{
    public function __invoke(Request $request): Response
    {
        $code = $request->request->get('code') ?? null;
        $requestedWithHeader = $request->headers->get('X-Requested-With');

        return $this->json(
            $this->dispatch(new SignInWithGoogleCommand(
                $code,
                $requestedWithHeader
            )),
            JsonResponse::HTTP_OK
        );
    }
}
