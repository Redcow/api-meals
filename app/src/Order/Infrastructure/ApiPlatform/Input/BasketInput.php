<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;

use App\Common\Domain\Entity\Collection;

final readonly class BasketInput
{
    /** @var Collection<ArticleInput> */
    public Collection $articles;
    public function __construct(
        array $articleIds
    ) {
        $articleList = array_map(
            fn (array $json) => $this->createArticleInput($json),
            $articleIds
        );

        $this->articles = new Collection($articleList);
    }

    private function createArticleInput(array $json): ArticleInput
    {
        return new ArticleInput(
            (int)$json['id'],
            (int)$json['quantity']
        );
    }
}