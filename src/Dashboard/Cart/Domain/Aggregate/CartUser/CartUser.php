<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartUser;

class CartUser
{
    private CartUserId $id;

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id->value();
    }
}
