<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\ClientUser;

interface ClientUserRepositoryInterface
{
    public function persist(ClientUser $client): ClientUser;
}