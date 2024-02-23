<?php

namespace App\Order\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Order\Infrastructure\ApiPlatform\Input\BasketInput;
use App\Order\Infrastructure\ApiPlatform\Processor\CreateOrderProcessor;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/order',
            shortName: "new command",
            security: "is_granted('ROLE_CLIENT')",
            input: BasketInput::class,
            processor: CreateOrderProcessor::class
        )
    ],
    routePrefix: '/orders'
)]
class OrderResource
{

}