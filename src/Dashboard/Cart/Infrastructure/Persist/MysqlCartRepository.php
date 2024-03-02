<?php

namespace App\Dashboard\Cart\Infrastructure\Persist;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

class MysqlCartRepository extends ServiceEntityRepository implements ICartRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $cart): Cart
    {
        $em = $this->getEntityManager();

        $em->persist($cart);
        $em->flush();

        return $cart;
    }

    public function remove(Cart $cart): void
    {
        $em = $this->getEntityManager();

        $em->remove($cart);
        $em->flush();
    }

    public function search(string $id): ?Cart
    {
        return $this->getEntityManager()->getRepository(Cart::class)->find($id) ?? null;
    }

    public function searchItem(string $itemId): ?CartItem
    {
        return $this->getEntityManager()->getRepository(CartItem::class)->find($itemId) ?? null;
    }

    public function searchAvailableProductItem(string $productId): Collection
    {
        return new ArrayCollection($this->getEntityManager()->getRepository(CartItem::class)->findBy([
            'product' => $productId,
            'state.value' => CartItemState::AVAILABLE,
        ]));
    }
}
