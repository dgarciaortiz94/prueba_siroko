<?php

namespace App\Entrypoint\Controller\Dashboard\Cart;

use App\Dashboard\Cart\Application\CreateCart\CreateCartCommand;
use App\Dashboard\Cart\Domain\Exception\NoAvailableItemsException;
use App\Shared\Infrastructure\Symfony\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateCartController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $response = $this->dispatch(new CreateCartCommand(
                $data->productId,
            ));
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
