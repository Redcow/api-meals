<?php

namespace App\Order\Domain\Registry;

enum OrderStatusEnum
{
    case UNPAID;
    case DELIVERED;
    case PAID;

    case INVALID;
}