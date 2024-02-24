<?php

namespace App\Tests\Dashboard\User\Application\RegisterUser;

use App\Dashboard\User\Application\Register\RegisterUserWithApplication\RegisterUserWithApplicationCase;
use App\Dashboard\User\Application\Register\Shared\RegisterUserResponse;
use App\Dashboard\User\Application\Register\Shared\UserRegister;
use App\Dashboard\User\Domain\Agregate\Exceptions\InvalidPasswordFormatException;
use App\Dashboard\User\Domain\Agregate\Exceptions\PasswordNotEqualsException;
use App\Dashboard\User\Domain\Services\UserFinderByEmail;
use App\Tests\Dashboard\User\Application\AbstractUserApplicationMock;
use App\Tests\Dashboard\User\Domain\RegisterUserMother;
use PharIo\Manifest\InvalidEmailException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RegisterUserTest extends AbstractUserApplicationMock
{
    protected UserFinderByEmail|MockObject|null $userFinderByEmail = null;

    /**
     * @test
     */
    public function shouldRegisterUserSuccessfully()
    {
        $user = RegisterUserMother::register();

        $this->repository()->expects($this->once())
            ->method('save')
            ->willReturn($user);

        $registerUserCase = new RegisterUserWithApplicationCase(
            new UserRegister($this->repository(), $this->userFinderByEmail()),
            $this->eventBus()
        );

        $registerUserResponse = $registerUserCase->__invoke($user);

        $this->assertEquals(RegisterUserResponse::class, $registerUserResponse::class);
    }

    /**
     * @test
     */
    public function shouldReturnConflictResponse()
    {
        $user = RegisterUserMother::register(
            email: 'dgarciaortiz94@gmail.com',
            plainPassword: '@Prueba123',
            repeatedPlainPassword: '@Prueba123'
        );

        $userFinderByEmail = $this->userFinderByEmail();

        $userFinderByEmail->expects($this->once())
            ->method('__invoke')
            ->willReturn($user);

        $this->repository();

        $registerUserCase = new RegisterUserWithApplicationCase(
            new UserRegister($this->repository(), $this->userFinderByEmail()), 
            $this->eventBus()
        );

        $this->expectException(ConflictHttpException::class);

        $registerUserResponse = $registerUserCase->__invoke($user);
    }

    /**
     * @test
     */
    public function shouldThrowInvalidEmailException()
    {
        $this->expectException(InvalidEmailException::class);

        $wrongEmailUser = RegisterUserMother::register(email: 'this-is-not-mail');
    }

    /**
     * @test
     */
    public function shouldThrowInvalidPasswordException()
    {
        $this->expectException(InvalidPasswordFormatException::class);

        $wrongPasswordUser = RegisterUserMother::register(
            plainPassword: '@Prueba',
            repeatedPlainPassword: '@Prueba'
        );
    }

    /**
     * @test
     */
    public function shouldThrowPasswordNotEqualsException()
    {
        $this->expectException(PasswordNotEqualsException::class);

        $notEqualsPasswordUser = RegisterUserMother::register(
            plainPassword: '@Prueba123',
            repeatedPlainPassword: '@Prueba123-not-match'
        );
    }

    protected function userFinderByEmail(): UserFinderByEmail|MockObject
    {
        $userFinderByEmail = $this->getMockBuilder(UserFinderByEmail::class)->disableOriginalConstructor()->getMock();

        return $this->userFinderByEmail ??= $userFinderByEmail;
    }
}
