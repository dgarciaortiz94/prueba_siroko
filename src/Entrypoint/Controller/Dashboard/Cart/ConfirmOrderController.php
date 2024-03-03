<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\ConfirmOrder\ConfirmOrderCommand;
use App\Dashboard\Cart\Domain\Exception\NoItemsInCartException;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfirmOrderController extends BaseController
{
    public function __invoke(
        string $cartId,
        #[MapRequestPayload(
            validationFailedStatusCode: JsonResponse::HTTP_BAD_REQUEST
        )] ConfirmOrderCommand $confirmOrderCommand
    ): JsonResponse {
        $confirmOrderCommand->setCartId($cartId);

        try {
            $response = $this->dispatch($confirmOrderCommand);
        } catch (NoItemsInCartException|NotFoundHttpException $e) {
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
