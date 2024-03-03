<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Shared\Domain\Bus\Command\ICommand;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCartCommand implements ICommand
{
    public function __construct(
        #[Assert\Type('string'), Assert\NotNull()]
        private string $productId
    ) {
    }

    /**
     * Get the value of productId.
     */
    public function productId(): string
    {
        return $this->productId;
    }
}
