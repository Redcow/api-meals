<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Order\Infrastructure\ApiPlatform\Processor\AddArticleProcessor;

/*#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/articles',
            processor: AddArticleProcessor::class
        )
    ],
    routePrefix: '/orders'
)]*/
class ArticleResource
{

}