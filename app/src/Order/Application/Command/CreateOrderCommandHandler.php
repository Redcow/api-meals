<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Registry\OrderStatusEnum;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class CreateOrderCommandHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository
    ){}

    public function __invoke(CreateOrderCommand $command): Order
    {
        $order = new Order(
            articles: $command->articles,
            status: OrderStatusEnum::UNPAID,
            client: $command->client,
            createdAt: new \DateTimeImmutable()
        );

        return $this->repository->persist($order);
    }
}