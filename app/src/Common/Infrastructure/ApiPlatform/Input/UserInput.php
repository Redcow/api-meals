<?php

namespace App\Common\Infrastructure\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UserInput
{
    public function __construct(
        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Email(groups: ['create'])]
        public ?string $email = null,

        #[Assert\NotNull(groups: ['create', 'update'])]
        #[Assert\Length(min: 2, max: 20, groups: ['create', 'update'])]
        public ?string $username = null,

        #[Assert\Length(min: 8, max: 50, groups: ['create'])]
        #[Assert\NotNull(groups: ['create'])]
        public ?string $password = null,

        /*#[Assert\NotNull(groups: ['update'])]
        public ?int $id = null,*/
    ){}
}