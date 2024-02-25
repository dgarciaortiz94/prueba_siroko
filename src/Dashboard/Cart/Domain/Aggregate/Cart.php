<?php

namespace App\Dashboard\Cart\Domain\Aggregate;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartUser\CartUser;
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

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of item.
     */
    public function getItem(): Collection
    {
        return $this->items;
    }

    /**
     * Get the value of user.
     */
    public function getUser(): CartUser
    {
        return $this->user;
    }

    /**
     * Get the value of created_At.
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updated_At.
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Get the value of active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
