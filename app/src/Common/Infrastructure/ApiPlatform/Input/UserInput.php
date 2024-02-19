<?php

namespace App\Common\Infrastructure\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UserInput
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\Length(min: 8, max: 50)]
        #[Assert\NotNull]
        #[Assert\NotBlank]
        public string $password,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 20)]
        public string $username,
    ){}
}