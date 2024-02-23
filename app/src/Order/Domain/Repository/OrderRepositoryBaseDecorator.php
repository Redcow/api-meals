<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\Order;

class OrderRepositoryBaseDecorator implements OrderRepositoryInterface
{
    protected OrderRepositoryInterface $wrappee;

    public function __construct(
        OrderRepositoryInterface $wrappee
    ){
        $this->wrappee = $wrappee;
    }

    public function persist(Order $order): Order
    {
        return $this->wrappee->persist($order);
    }
}