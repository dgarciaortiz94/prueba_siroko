<?php

namespace App\Dashboard\Cart\Infrastructure\Persist;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MysqlCartRepository extends ServiceEntityRepository implements ICartRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $cart): Cart
    {
        $this->getEntityManager()->persist($cart);

        $this->getEntityManager()->flush();

        return $cart;
    }

    public function remove(Cart $cart): void
    {
        $this->getEntityManager()->remove($cart);

        $this->getEntityManager()->flush();
    }

    public function search(string $id): Cart
    {
        return $this->getEntityManager()->getRepository(Cart::class)->find($id);
    }

    public function searchProduct(string $id): CartItemProduct
    {
        return $this->getEntityManager()->getRepository(CartItemProduct::class)->find($id);
    }
}
