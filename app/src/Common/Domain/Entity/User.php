<?php

namespace App\Common\Domain\Entity;

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
        public ?int   $id = null
    ){}

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