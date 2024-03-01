<?php

namespace App\Order\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\IAppCache;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\IOrderRepository;
use App\Order\Infrastructure\Doctrine\Repository\OrderRepository as OrderDoctrineRepository;

class OrderRepositoryFactory implements IOrderRepository
{

    private IOrderRepository $repository;

    public function __invoke(
        OrderDoctrineRepository $orderDoctrineRepository,
        IAppCache $cache
    ): IOrderRepository
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