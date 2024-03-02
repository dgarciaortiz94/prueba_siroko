<?php

namespace App\Dashboard\Cart\Application\Shared;

use App\Shared\Domain\Bus\Command\ICommandResponse;

class CartResponse implements ICommandResponse
{
    private array $items;

    public function __construct(
        private string $cartId,
        private float $total,
        CartItemResponse ...$items
    ) {
        $this->items = $items;
    }

    /**
     * Get the value of cartId.
     */
    public function getCartId(): string
    {
        return $this->cartId;
    }

    /**
     * Get the value of items.
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get the value of total.
     */
    public function getTotal(): float
    {
        return $this->total;
    }
}
