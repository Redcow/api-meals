<?php

namespace App\Order\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\AppCacheInterface;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Order\Infrastructure\Doctrine\Repository\OrderRepository as OrderDoctrineRepository;

class OrderRepositoryFactory implements OrderRepositoryInterface
{

    private OrderRepositoryInterface $repository;

    public function __invoke(
        OrderDoctrineRepository $orderDoctrineRepository,
        AppCacheInterface $cache
    ): OrderRepositoryInterface
    {
        $this->repository = new OrderRepositoryCacheDecorator(
            $orderDoctrineRepository,
            $cache
        );

        return $this;
    }

    public function persist(Order $order): Order
    {
        return $this->repository->persist($order);
    }
}