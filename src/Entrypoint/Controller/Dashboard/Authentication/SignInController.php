<?php

namespace App\Entrypoint\Controller\Dashboard\Authentication;

use App\Dashboard\User\Application\SignIn\SignInWithApplication\SignInWithApplicationCommand;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignInController extends BaseController
{
    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent());

        return $this->json(
            $this->dispatch(new SignInWithApplicationCommand(
                $data->email,
                $data->password
            )),
            JsonResponse::HTTP_OK
        );
    }
}
