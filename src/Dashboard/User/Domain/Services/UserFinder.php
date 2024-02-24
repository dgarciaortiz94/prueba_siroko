<?php

namespace App\Dashboard\User\Domain\Services;

use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Agregate\UserId;
use App\Dashboard\User\Domain\Persist\IUserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserFinder
{
    public function __construct(private IUserRepository $repository)
    {
    }

    public function __invoke(UserId $id): User
    {
        $user = $this->repository->search($id->value());

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
