<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel;

class CartProductModel
{
    protected CartProductModelId $id;

    protected CartProductModelName $name;

    protected CartProductModelDescription $description;

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of name.
     */
    public function name(): string
    {
        return $this->name->value();
    }

    /**
     * Get the value of description.
     */
    public function description(): string
    {
        return $this->description->value();
    }
}
