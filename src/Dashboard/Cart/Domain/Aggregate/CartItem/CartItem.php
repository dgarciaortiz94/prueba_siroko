<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem;

class CartItem
{
    private CartItemId $id;

    private CartItemName $name;

    private CartItemDescription $description;

    private CartItemPrice $price;

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of name.
     */
    public function getName(): CartItemName
    {
        return $this->name;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): CartItemDescription
    {
        return $this->description;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): CartItemPrice
    {
        return $this->price;
    }
}
