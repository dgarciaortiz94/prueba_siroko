<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\AddProductToCart\AddProductToCartCommand;
use App\Dashboard\Cart\Domain\Exception\NoAvailableItemsException;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddProductToCartController extends BaseController
{
    public function __invoke(Request $request, string $cartId): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $response = $this->dispatch(new AddProductToCartCommand(
                $cartId,
                $data->productId,
            ));
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
