<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\CreateCart\CreateCartCommand;
use App\Dashboard\Cart\Domain\Exception\NoAvailableItemsException;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class CreateCartController extends BaseController
{
    public function __invoke(
        #[MapRequestPayload(
            validationFailedStatusCode: JsonResponse::HTTP_BAD_REQUEST
        )] CreateCartCommand $createCartCommand
    ): JsonResponse {
        try {
            $response = $this->dispatch($createCartCommand);
        } catch (NoAvailableItemsException $e) {
            return $this->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $response,
            JsonResponse::HTTP_OK
        );
    }
}
