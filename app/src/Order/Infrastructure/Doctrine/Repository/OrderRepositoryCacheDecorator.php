<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\AppCacheInterface;
use App\Meal\Domain\Entity\Meal;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepositoryBaseDecorator;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final class OrderRepositoryCacheDecorator
    extends OrderRepositoryBaseDecorator
    implements OrderRepositoryInterface
{
    private readonly AppCacheInterface $cache;

    public function __construct(OrderRepositoryInterface $wrappee, AppCacheInterface $cache)
    {
        $this->cache = $cache;
        parent::__construct($wrappee);
    }

    public function persist(Order $order): Order
    {
        $savedMeal = $this->wrappee->persist($order);

        if($this->cache->isOff()) {
            return $savedMeal;
        }

        return $this->cacheIt($savedMeal);
    }

    private function cacheIt(Order $order): Order
    {
        $this->cache->set(
            "ORDER:$order->id",
            json_encode($order)
        );

        return $order;
    }
}