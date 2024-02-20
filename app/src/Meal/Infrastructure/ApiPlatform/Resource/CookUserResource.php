<?php

namespace App\Meal\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Infrastructure\ApiPlatform\Processor\CreateCookProcessor;
use App\Meal\Infrastructure\ApiPlatform\Provider\CookItemProvider;

#[ApiResource(
    shortName: 'CookUser',
    operations: [
        new Post(
            uriTemplate: '/auth/signup',
            input: UserInput::class,
            processor: CreateCookProcessor::class
        ),
        new Get(
            uriTemplate: '/{id}',
            provider: CookItemProvider::class
        )
    ],
    routePrefix: '/cooks'
)]
final readonly class CookUserResource
{
    public function __construct(
        public string $email,
        public string $username,
        public array $roles,
        public ?int $id
    ) {}

    public static function fromDomain(CookUser $cook): CookUserResource
    {
        return new self(
            $cook->email,
            $cook->username,
            $cook->roles,
            $cook->id
        );
    }
}