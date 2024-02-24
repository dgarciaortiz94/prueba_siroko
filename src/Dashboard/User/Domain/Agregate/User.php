<?php

namespace App\Dashboard\User\Domain\Agregate;

use App\Dashboard\User\Domain\Agregate\Exceptions\PasswordNotEqualsException;
use App\Dashboard\User\Domain\Event\UserRegisteredEvent;
use App\Shared\Domain\Agregate\AgregateRoot;
use App\Shared\Domain\ValueObject\Uid\UuidValueObject;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AgregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    private UuidValueObject $id;

    private string $name;

    private string $surname;

    private ?string $secondSurname;

    private array $roles;

    private UserEmail $email;

    private UserPlainPassword $plainPassword;

    private UserPlainPassword $repeatedPlainPassword;

    private UserHashedPassword $lastHashedPassword;

    private UserHashedPassword $hashedPassword;

    private UserProvider $provider;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    private bool $active;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];

        $this->createdAt = new \DateTimeImmutable();
        $this->active = true;
    }

    public static function register(
        string $name,
        string $surname,
        string $email,
        string $plainPassword,
        string $repeatedPlainPassword,
        ?string $secondSurname
    ) {
        $self = new self();

        $self->id = new UserId();
        $self->name = $name;
        $self->surname = $surname;
        $self->secondSurname = $secondSurname;
        $self->email = new UserEmail($email);

        $self->plainPassword = new UserPlainPassword($plainPassword);
        $self->repeatedPlainPassword = new UserPlainPassword($repeatedPlainPassword);

        if (!$self->plainPassword->equals($self->repeatedPlainPassword)) {
            throw new PasswordNotEqualsException();
        }

        $self->provider = new UserProvider(UserProvider::APPLICATION);

        $self->record(new UserRegisteredEvent(
            $self->id->value(),
            $self->name,
            $self->surname,
            $self->secondSurname,
            $self->roles,
            $self->email->value(),
            $self->provider->value(),
            $self->createdAt->format('Y/m/d h:i:s')
        ));

        return $self;
    }

    public static function registerWithGoogle(
        string $name,
        string $surname,
        string $email,
        ?string $secondSurname
    ) {
        $self = new self();

        $self->id = new UserId();
        $self->name = $name;
        $self->surname = $surname;
        $self->secondSurname = $secondSurname;
        $self->email = new UserEmail($email);

        $self->provider = new UserProvider(UserProvider::GOOGLE);

        $self->record(new UserRegisteredEvent(
            $self->id->value(),
            $self->name,
            $self->surname,
            $self->secondSurname,
            $self->roles,
            $self->email->value(),
            $self->provider->value(),
            $self->createdAt->format('Y/m/d h:i:s')
        ));

        return $self;
    }

    public function update(
        string $name,
        string $surname,
        string $secondSurname,
        string $email,
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->secondSurname = $secondSurname;
        $this->email = new UserEmail($email);

        return $this;
    }

    public function updatePassword(
        string $newPlainPassword,
        string $repeatedNewPlainPassword,
        string $hashedPassword,
    ) {
        $this->plainPassword = new UserPlainPassword($newPlainPassword);
        $this->repeatedPlainPassword = new UserPlainPassword($repeatedNewPlainPassword);

        if (!$this->plainPassword->equals($this->repeatedPlainPassword)) {
            throw new PasswordNotEqualsException();
        }

        $this->hashedPassword = $hashedPassword;

        return $this;
    }

    /**
     * Get the value of id.
     */
    public function getUserIdentifier(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get the value of surname.
     */
    public function surname(): string
    {
        return $this->surname;
    }

    /**
     * Get the value of secondSurname.
     */
    public function secondSurname(): ?string
    {
        return $this->secondSurname;
    }

    /**
     * Get the value of email.
     */
    public function email(): string
    {
        return $this->email->value();
    }

    /**
     * Get the value of hashedPassword.
     */
    public function getPassword(): string
    {
        return $this->hashedPassword->value();
    }

    /**
     * Get the value of hashedPassword.
     */
    public function setPassword(UserHashedPassword $hashedPassword): self
    {
        $this->hashedPassword = $hashedPassword;

        return $this;
    }

    /**
     * Get the value of provider.
     */
    public function isApplicationProvider(): string
    {
        return UserProvider::APPLICATION === $this->provider->value();
    }

    /**
     * Get the value of provider.
     */
    public function isGoogleProvider(): string
    {
        return UserProvider::GOOGLE === $this->provider->value();
    }

    /**
     * Get the value of createdAt.
     */
    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt.
     */
    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Get the value of active.
     */
    public function active(): bool
    {
        return $this->active;
    }

    /**
     * Get the value of roles.
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
        // $this->hashedPassword = new UserHashedPassword('');
    }
}
