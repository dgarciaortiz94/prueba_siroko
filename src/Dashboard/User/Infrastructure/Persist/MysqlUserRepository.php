<?php

namespace App\Dashboard\User\Infrastructure\Persist;

use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Persist\IUserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MysqlUserRepository extends ServiceEntityRepository implements IUserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);

        $this->getEntityManager()->flush();

        return $user;
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);

        $this->getEntityManager()->flush();
    }

    public function search(string $id): User
    {
        return $this->getEntityManager()->getRepository(User::class)->find($id);
    }

    public function searchByCriteria(array $criteria): array
    {
        return $this->getEntityManager()->getRepository(User::class)->findBy($criteria);
    }
}
