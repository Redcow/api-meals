<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;

use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Infrastructure\ApiPlatform\Processor\CreateClientUserProcessor;

#[ApiResource(
    shortName: 'ClientUser',
    operations: [
        new Post(
            uriTemplate: '/auth/signup',
            input: UserInput::class,
            processor: CreateClientUserProcessor::class
        )
    ],
    routePrefix: '/orders'
)]
class ClientUserResource
{
    public function __construct(
        public string $email,
        public string $username,
        public array $roles,
        public ?int $id
    ) {}

    public static function fromDomain(ClientUser $clientUser): self
    {
        return new self(
            $clientUser->email,
            $clientUser->username,
            $clientUser->roles,
            $clientUser->id
        );
    }
}