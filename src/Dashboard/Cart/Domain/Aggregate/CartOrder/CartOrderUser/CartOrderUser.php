<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderUser;

use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataId;
use Symfony\Component\Security\Core\User\UserInterface;

class CartOrderUser implements UserInterface
{
    private CartOrderUserId $id;

    private function __construct(CartOrderUserId $id = null)
    {
        $this->id = new CartOrderPaymentDataId();
    }

    public static function create(CartOrderUserId $id): self
    {
        $self = new self();

        $self->id = $id;

        return $self;
    }

    public function getUserIdentifier(): string
    {
        return $this->id->value();
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }
}
