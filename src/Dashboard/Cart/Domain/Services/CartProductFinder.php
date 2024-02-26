<?php

namespace App\Dashboard\Cart\Domain\Services;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartProductFinder implements ICommandResponse
{
    public function __construct(private ICartRepository $repository)
    {
    }

    public function __invoke(CartItemProductId $id): CartItemProduct
    {
        $product = $this->repository->searchProduct($id->value());

        $this->checkItemExists($product);

        return $product;
    }

    private function checkItemExists(?CartItemProduct $product): void
    {
        if (!$product) {
            throw new NotFoundHttpException('Item not found by this id');
        }
    }
}
