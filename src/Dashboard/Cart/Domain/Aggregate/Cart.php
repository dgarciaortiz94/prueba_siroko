<?php

namespace App\Dashboard\Cart\Domain\Aggregate;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrder;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataAddress;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataComunity;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataLocation;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataZipCode;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderItemSnapshot\CartOrderItemSnapshot;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderItemSnapshot\CartOrderItemSnapshotPrice;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataCard;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderUser\CartOrderUserId;
use App\Dashboard\Cart\Domain\Aggregate\CartUser\CartUser;
use App\Dashboard\Cart\Domain\Exception\ItemAlreadyInsideCartException;
use App\Dashboard\Cart\Domain\Exception\ItemNotFoundInsideCartException;
use App\Dashboard\Cart\Domain\Exception\NoItemsInCartException;
use App\Shared\Domain\Agregate\AgregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart extends AgregateRoot
{
    private CartId $id;

    private Collection $items;

    private ?CartUser $user;

    private ?CartOrder $order;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private bool $active;

    private function __construct()
    {
        $this->id = new CartId();

        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->active = true;
    }

    public static function create(
        CartItem $item,
        CartUser $user = null
    ): self {
        $self = new Cart();

        $item->changeState(new CartItemState(CartItemState::RESERVED));
        $self->items->add($item);
        $self->user = $user;

        return $self;
    }

    public function createOrder(
        CartOrderAddressDataAddress $shipmentAddress,
        CartOrderAddressDataLocation $shipmenLocation,
        CartOrderAddressDataComunity $shipmenComunity,
        CartOrderAddressDataZipCode $shipmenZipCode,
        CartOrderPaymentDataCard $card,
        CartOrderUserId $userId = null
    ): CartOrder {
        if (0 === count($this->items)) {
            throw new NoItemsInCartException();
        }

        $itemSnapshots = $this->items->map(function (CartItem $cartItem) {
            $cartItem->changeState(new CartItemState(CartItemState::SOLD));

            return CartOrderItemSnapshot::create(
                $cartItem,
                new CartOrderItemSnapshotPrice($cartItem->price())
            );
        });

        $this->order = CartOrder::create(
            $shipmentAddress,
            $shipmenLocation,
            $shipmenComunity,
            $shipmenZipCode,
            $card,
            $userId,
            ...$itemSnapshots
        );

        return $this->order;
    }

    public function addProduct(CartItem $item): self
    {
        if ($this->items->contains($item)) {
            throw new ItemAlreadyInsideCartException();
        }

        $this->items()->add($item);
        $item->changeState(new CartItemState(CartItemState::RESERVED));

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
     * Get the value of order.
     */
    public function order(): CartOrder
    {
        return $this->order;
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
