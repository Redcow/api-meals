<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;

use App\Meal\Domain\Entity\CookUser;

use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Meal\Infrastructure\ApiPlatform\Processor\CreateCookProcessor;
use App\Meal\Infrastructure\ApiPlatform\Processor\UpdateCookProcessor;
use App\Meal\Infrastructure\ApiPlatform\Provider\CookItemProvider;

#[ApiResource(
    shortName: 'CookUser',
    operations: [
        new Post(
            uriTemplate: '/auth/signup',
            security: "is_granted('ROLES_COOK')",
            validationContext: [
                'groups' => ['create']
            ],
            input: UserInput::class,
            processor: CreateCookProcessor::class
        ),
        new Get(
            uriTemplate: '/{id}',
            normalizationContext: ['normalization' => 'oui'],
            provider: CookItemProvider::class,
        ),
        new Put(
            uriTemplate: '/{id}',
            security: "is_granted('ROLE_COOK') and object.id === user.getId()",
            validationContext: [
                'groups' => ['update']
            ],
            input: UserInput::class,
            provider: CookItemProvider::class,
            processor: UpdateCookProcessor::class
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