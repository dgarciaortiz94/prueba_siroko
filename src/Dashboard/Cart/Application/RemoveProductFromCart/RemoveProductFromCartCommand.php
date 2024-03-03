<?php

namespace App\Dashboard\Cart\Application\RemoveProductFromCart;

use App\Shared\Domain\Bus\Command\ICommand;
use Symfony\Component\Validator\Constraints as Assert;

class RemoveProductFromCartCommand implements ICommand
{
    public function __construct(
        private ?string $cartId,
        #[Assert\NotNull(), Assert\Type('string')]
        private string $itemId
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
    public function itemId(): string
    {
        return $this->itemId;
    }
}
