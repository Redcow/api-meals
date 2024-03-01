<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\ClientUser;

interface IClientUserRepository
{
    public function persist(ClientUser $client): ClientUser;
}