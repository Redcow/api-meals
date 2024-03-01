<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\ValueObject\UserStatus;

/**
 * @template T
 */
readonly class User
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username,
        public array  $roles = [],
        public UserStatus $status = UserStatus::OFF,
        public ?string $token = null,
        public ?int   $id = null
    ){}

    public function createToken(): string
    {
        return bin2hex(random_bytes(60));
    }

    /**
     * @return T
     */
    public function with(...$properties): static
    {
        return new static(
            email: $properties['email'] ?? $this->email,
            password: $properties['password'] ?? $this->password,
            username: $properties['username'] ?? $this->username,
            roles: $properties['roles'] ?? $this->roles,
            id: $properties['id'] ?? $this->id
        );
    }


}