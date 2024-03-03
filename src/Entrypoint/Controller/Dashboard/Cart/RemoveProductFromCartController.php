<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\RemoveProductFromCart\RemoveProductFromCartCommand;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveProductFromCartController extends BaseController
{
    public function __invoke(
        string $cartId,
        #[MapRequestPayload(
            validationFailedStatusCode: JsonResponse::HTTP_BAD_REQUEST
        )] RemoveProductFromCartCommand $removeProductFromCartCommand
    ): JsonResponse {
        $removeProductFromCartCommand->setCartId($cartId);

        try {
            $response = $this->dispatch($removeProductFromCartCommand);
        } catch (NotFoundHttpException $e) {
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
