<?php

namespace App\Order\Infrastructure\Doctrine\Repository;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\IOrderRepository;

class OrderRepositoryBaseDecorator implements IOrderRepository
{
    protected IOrderRepository $wrappee;

    public function __construct(
        IOrderRepository $wrappee
    ){
        $this->wrappee = $wrappee;
    }

    public function persist(Order $order): Order
    {
        return $this->wrappee->persist($order);
    }
}