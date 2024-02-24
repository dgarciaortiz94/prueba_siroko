<?php

namespace App\Tests\Dashboard\User\Infrastructure\TokenGenerator;

use App\Dashboard\User\Infrastructure\TokenGenerator\CustomJwtGenerator;
use App\Tests\Dashboard\User\Domain\RegisterUserMother;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomJwtGeneratorTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @test
     */
    public function generateTokenTest()
    {
        $jwtProvider = $this->getContainer()->get(CustomJwtGenerator::class);

        $token = $jwtProvider->generateToken(RegisterUserMother::register());

        $this->assertIsString($token);
    }
}
