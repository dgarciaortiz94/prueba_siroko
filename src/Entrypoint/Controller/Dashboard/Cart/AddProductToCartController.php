<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\AddProductToCart\AddProductToCartCommand;
use App\Dashboard\Cart\Domain\Exception\NoAvailableItemsException;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddProductToCartController extends BaseController
{
    public function __invoke(
        string $cartId,
        #[MapRequestPayload(
            validationFailedStatusCode: JsonResponse::HTTP_BAD_REQUEST
        )] AddProductToCartCommand $addProductToCartCommand
    ): JsonResponse {
        $addProductToCartCommand->setCartId($cartId);

        try {
            $response = $this->dispatch($addProductToCartCommand);
        } catch (NoAvailableItemsException|NotFoundHttpException $e) {
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
