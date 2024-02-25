<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel;

class CartProductModel
{
    private CartProductModelId $id;

    private CartProductModelName $name;

    private CartProductModelDescription $description;

    /**
     * Get the value of id.
     */
    public function getId(): CartProductModelId
    {
        return $this->id;
    }

    /**
     * Get the value of name.
     */
    public function getName(): CartProductModelName
    {
        return $this->name;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): CartProductModelDescription
    {
        return $this->description;
    }
}
