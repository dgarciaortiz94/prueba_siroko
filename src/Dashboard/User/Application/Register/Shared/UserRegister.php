<?php

namespace App\Dashboard\User\Application\Register\Shared;

use App\Dashboard\User\Domain\Agregate\User;
use App\Dashboard\User\Domain\Persist\IUserRepository;
use App\Dashboard\User\Domain\Services\UserFinderByEmail;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class UserRegister
{
    public function __construct(
        private IUserRepository $repository,
        private UserFinderByEmail $finder
    ) {
    }

    public function __invoke(User $user): User
    {
        $this->validateExistentUser($user->email());

        return $this->repository->save($user);
    }

    public function validateExistentUser(string $email)
    {
        try {
            if ($this->finder->__invoke($email)) {
                throw new ConflictHttpException('This user is already created');
            }
        } catch (NotFoundHttpException $e) {
        }
    }
}
