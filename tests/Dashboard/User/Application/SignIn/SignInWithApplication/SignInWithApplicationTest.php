<?php

namespace App\Tests\Dashboard\User\Application\SignIn\SignInWithApplication;

use App\Dashboard\User\Application\SignIn\Exception\SignInWrongProviderException;
use App\Dashboard\User\Application\SignIn\Shared\SignInResponse;
use App\Dashboard\User\Application\SignIn\SignInWithApplication\Services\UserPasswordChecker;
use App\Dashboard\User\Application\SignIn\SignInWithApplication\SignInWithApplicationCase;
use App\Dashboard\User\Application\SignIn\SignInWithApplication\Utils\SignInWithApplicationCredentials;
use App\Dashboard\User\Domain\Services\UserFinderByEmail;
use App\Dashboard\User\Infrastructure\TokenGenerator\CustomJwtGenerator;
use App\Tests\Dashboard\User\Application\AbstractUserApplicationMock;
use App\Tests\Dashboard\User\Domain\RegisterUserMother;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;

class SignInWithApplicationTest extends AbstractUserApplicationMock
{
    protected UserPasswordChecker|MockObject|null $userPasswordChecker = null;
    protected CustomJwtGenerator|MockObject|null $tokenGenerator = null;

    /**
     * @test
     */
    public function shouldAuthenticateUserSuccessfully()
    {
        $userPasswordChecker = $this->userPasswordChecker();

        $userPasswordChecker
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(true);

        $tokenGenerator = $this->tokenGenerator();

        $tokenGenerator
            ->expects($this->once())
            ->method('generateToken')
            ->willReturn('
                eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9
                .eyJhdWQiOiJodHRwOi8vbG9jYWxob3N0IiwiZXhwIjozMDAw
                MDAsImlhdCI6MTI3MzQ3NDM5MzQsImlzcyI6Imh0dHA6Ly9le
                GFtcGxlLmNvbSIsIm5iZiI6MTI3MzQ3NDUwMDAsIm5hbWUiOi
                JEaWVnbyIsInN1cm5hbWUiOiJHYXJjw61hIiwic2Vjb25kU3V
                ybmFtZSI6Ik9ydGl6IiwiZW1haWwiOiJtYWlsQG1haWwuY29t
                Iiwicm9sZXMiOlsiUk9MRV9VU0VSIl19
                .9kOZwl5LfMHQtc4bmH1Ts1cgPs6Rg7Lcza0yjFWVwWo
            ');

        $repository = $this->repository();

        $repository
            ->expects($this->once())
            ->method('searchByCriteria')
            ->willReturn([RegisterUserMother::register()]);

        $authenticateUserCase = new SignInWithApplicationCase(new UserFinderByEmail($repository), $userPasswordChecker, $tokenGenerator);

        $registerUserResponse = $authenticateUserCase->__invoke(SignInWithApplicationCredentials::create('mail@mail.com', '@Prueba123'));

        $this->assertEquals(SignInResponse::class, $registerUserResponse::class);
    }

    /**
     * @test
     */
    public function shouldThrowNotFoundHttpException()
    {
        $userPasswordChecker = $this->userPasswordChecker();

        $repository = $this->repository();

        $repository
            ->expects($this->once())
            ->method('searchByCriteria')
            ->willReturn([]);

        $this->expectException(NotFoundHttpException::class);

        $signInWithApplicationCase = new SignInWithApplicationCase(new UserFinderByEmail($this->repository()), $userPasswordChecker, $this->tokenGenerator());

        $signInWithApplicationCase->__invoke(SignInWithApplicationCredentials::create('no_existent_user@mail.com', '@Prueba123'));
    }

    /**
     * @test
     */
    public function shouldThrowInvalidProviderException()
    {
        $userPasswordChecker = $this->userPasswordChecker();

        $repository = $this->repository();

        $repository
            ->expects($this->once())
            ->method('searchByCriteria')
            ->willReturn([RegisterUserMother::registerWithGoogle(
                email: 'dgarciaortiz94@gmail.com'
            )]);

        $signInWithApplicationCase = new SignInWithApplicationCase(new UserFinderByEmail($this->repository()), $userPasswordChecker, $this->tokenGenerator());

        $this->expectException(SignInWrongProviderException::class);

        $signInWithApplicationCase->__invoke(SignInWithApplicationCredentials::create('dgarciaortiz94@gmail.com', '@Prueba123'));
    }

    /**
     * @test
     */
    public function shouldThrowWrongPasswordException()
    {
        $userPasswordChecker = $this->userPasswordChecker();

        $userPasswordChecker
            ->expects($this->once())
            ->method('__invoke')
            ->willThrowException(new InvalidPasswordException('Password is not correct'));

        $repository = $this->repository();

        $repository
            ->expects($this->once())
            ->method('searchByCriteria')
            ->willReturn([RegisterUserMother::register()]);

        $signInWithApplicationCase = new SignInWithApplicationCase(new UserFinderByEmail($this->repository()), $userPasswordChecker, $this->tokenGenerator());

        $this->expectException(InvalidPasswordException::class);

        $signInWithApplicationCase->__invoke(SignInWithApplicationCredentials::create('mail@mail.com', '@Prueba123_wrong'));
    }

    protected function userPasswordChecker(): UserPasswordChecker|MockObject
    {
        $userPasswordChecker = $this->getMockBuilder(UserPasswordChecker::class)->disableOriginalConstructor()->getMock();

        return $this->userPasswordChecker ??= $userPasswordChecker;
    }

    protected function tokenGenerator(): CustomJwtGenerator|MockObject
    {
        $tokenGenerator = $this->getMockBuilder(CustomJwtGenerator::class)->disableOriginalConstructor()->getMock();

        return $this->tokenGenerator ??= $tokenGenerator;
    }
}
