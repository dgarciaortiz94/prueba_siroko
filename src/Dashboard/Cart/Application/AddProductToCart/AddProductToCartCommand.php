<?php

namespace App\Dashboard\Cart\Application\AddProductToCart;

use App\Shared\Domain\Bus\Command\ICommand;
use Symfony\Component\Validator\Constraints as Assert;

class AddProductToCartCommand implements ICommand
{
    public function __construct(
        public ?string $cartId,
        #[Assert\NotNull(), Assert\Type('string')]
        private string $productId
    ) {
    }

    /**
     * Get the value of cartId.
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * Set the value of cartId.
     */
    public function setCartId(string $cartId): self
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * Get the value of productId.
     */
    public function productId(): string
    {
        return $this->productId;
    }
}
