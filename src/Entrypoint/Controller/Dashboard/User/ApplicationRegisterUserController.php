<?php

namespace App\Entrypoint\Controller\Dashboard\User;

use App\Dashboard\User\Application\Register\RegisterUserWithApplication\RegisterUserWithApplicationCommand;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApplicationRegisterUserController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        return $this->json(
            $this->dispatch(new RegisterUserWithApplicationCommand(
                $data->name,
                $data->surname,
                $data->email,
                $data->password,
                $data->repeatedPassword,
                $data->secondSurname
            )),
            JsonResponse::HTTP_OK
        );
    }
}
