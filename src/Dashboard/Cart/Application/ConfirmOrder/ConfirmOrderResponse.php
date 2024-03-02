<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

use App\Shared\Domain\Bus\Command\ICommandResponse;

class ConfirmOrderResponse implements ICommandResponse
{
    private array $items;

    public function __construct(
        private ConfirmOrderShipmentAddressResponse $shipmentAddress,
        ConfirmOrderItemSnapshotResponse ...$items
    ) {
        $this->items = $items;
    }

    /**
     * Get the value of shipmentAddress.
     */
    public function getShipmentAddress(): ConfirmOrderShipmentAddressResponse
    {
        return $this->shipmentAddress;
    }

    /**
     * Get the value of items.
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
