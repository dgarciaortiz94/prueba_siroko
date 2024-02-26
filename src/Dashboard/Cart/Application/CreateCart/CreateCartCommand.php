<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Shared\Domain\Bus\Command\ICommand;

class CreateCartCommand implements ICommand
{
    public string $productId;
}
