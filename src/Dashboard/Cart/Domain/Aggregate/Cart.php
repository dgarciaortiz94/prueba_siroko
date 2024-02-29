<?php

namespace App\Dashboard\Cart\Domain\Aggregate;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Aggregate\CartUser\CartUser;
use App\Dashboard\Cart\Domain\Exception\ItemAlreadyInsideCartException;
use App\Dashboard\Cart\Domain\Exception\ItemNotFoundInsideCartException;
use App\Shared\Domain\Agregate\AgregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart extends AgregateRoot
{
    private CartId $id;

    private Collection $items;

    private ?CartUser $user;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private bool $active;

    private function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->active = true;
    }

    public static function create(
        CartItem $item,
        CartUser $user = null
    ): self {
        $self = new Cart();

        $self->id = new CartId();
        $self->items->add($item);
        $self->user = $user;

        return $self;
    }

    public function addProduct(CartItem $item): self
    {
        if ($this->items->contains($item)) {
            throw new ItemAlreadyInsideCartException();
        }

        $this->items()->add($item);
        $item->changeState(new CartItemState(CartItemState::AVAILABLE));

        return $this;
    }

    public function removeProduct(CartItem $item): self
    {
        if (!$this->items->contains($item)) {
            throw new ItemNotFoundInsideCartException();
        }

        $item->changeState(new CartItemState(CartItemState::AVAILABLE));
        $this->items()->removeElement($item);

        return $this;
    }

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of item.
     */
    public function items(): Collection
    {
        return $this->items;
    }

    /**
     * Get the value of user.
     */
    public function user(): CartUser
    {
        return $this->user;
    }

    /**
     * Get the value of created_At.
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updated_At.
     */
    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Get the value of active.
     */
    public function active(): bool
    {
        return $this->active;
    }
}
