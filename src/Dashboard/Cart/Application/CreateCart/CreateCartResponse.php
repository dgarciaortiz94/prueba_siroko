<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Shared\Domain\Bus\Command\ICommandResponse;

class CreateCartResponse implements ICommandResponse
{
    private array $items;

    public function __construct(
        private string $cartId,
        private float $total,
        CreateCartItemResponse ...$items
    ) {
        $this->items = $items;
    }

    /**
     * Get the value of cartId.
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * Get the value of items.
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * Get the value of total.
     */
    public function total(): float
    {
        return $this->total;
    }
}
