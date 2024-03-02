<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Shared\Domain\Bus\Command\ICommand;

class CreateCartCommand implements ICommand
{
    public function __construct(private string $productId)
    {
    }

    /**
     * Get the value of productId.
     */
    public function productId(): string
    {
        return $this->productId;
    }
}
