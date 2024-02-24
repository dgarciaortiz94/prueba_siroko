<?php

namespace App\Dashboard\User\Domain\Persist;

use App\Dashboard\User\Domain\Agregate\User;

interface IUserRepository
{
    public function save(User $user): User;

    public function remove(User $user): void;

    public function search(string $id): User;

    public function searchByCriteria(array $criteria): array;
}
