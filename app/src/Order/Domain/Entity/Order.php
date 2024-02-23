<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\Entity\Collection;
use App\Order\Domain\Registry\OrderStatusEnum;

final readonly class Order
{
    public function __construct(
        /**
         * @var Collection<Article>
         */
        public Collection $articles,
        public OrderStatusEnum $status,
        public ClientUser $client,
        public \DateTimeImmutable $createdAt,
        public ?int $id = null,
    ){}

    public function getArticles(): array
    {
        return $this->articles->get();
    }

    public function addArticle(Article $article): void
    {
        $this->articles->add($article);
    }

    public function getTotalPrice(): int
    {
        return $this->articles->reduce(
            fn (int $total, Article $article) => $total + $article->getPrice(),
            0
        );
    }

    public function with ( ...$properties ): self
    {
        return new self(
            articles: $properties['articles'] ?? $this->articles,
            status: $properties['status'] ?? $this->status,
            client: $properties['client'] ?? $this->client,
            createdAt: $this->createdAt,
            id: $properties['id'] ?? $this->id
        );
    }
}