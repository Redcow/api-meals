<?php

namespace App\Cook\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Infrastructure\ApiPlatform\Processor\CreateCookProcessor;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/cooks/',
            input: UserInput::class,
            processor: CreateCookProcessor::class
        )
    ]
)]
final readonly class CookResource
{
    public function __construct(
        public string $email,
        public string $username,
        public array $roles,
        public ?int $id
    ) {}

    public static function fromDomain(Cook $cook): CookResource
    {
        return new self(
            $cook->email,
            $cook->username,
            $cook->roles,
            $cook->id
        );
    }
}