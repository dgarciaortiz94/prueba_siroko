<?php

namespace App\Dashboard\User\Domain\Services;

use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Persist\IUserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserFinderByEmail
{
    public function __construct(private IUserRepository $repository)
    {
    }

    public function __invoke(string $email): ?User
    {
        $user = $this->repository->searchByCriteria(['email.value' => $email])[0] ?? null;

        $this->checkUserExists($user);

        return $user;
    }

    private function checkUserExists(?User $user): void
    {
        if (!$user) {
            throw new NotFoundHttpException('User not found by this id');
        }
    }
}
