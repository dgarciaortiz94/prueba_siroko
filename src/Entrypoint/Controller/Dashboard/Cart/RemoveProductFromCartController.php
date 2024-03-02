<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\RemoveProductFromCart\RemoveProductFromCartCommand;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveProductFromCartController extends BaseController
{
    public function __invoke(Request $request, string $cartId): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $response = $this->dispatch(new RemoveProductFromCartCommand(
                $cartId,
                $data->itemId,
            ));
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
