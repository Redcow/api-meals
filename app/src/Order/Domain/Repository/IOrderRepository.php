<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\Article;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Domain\Entity\Order;

interface IOrderRepository
{
    public function persist(Order $order): Order;
}