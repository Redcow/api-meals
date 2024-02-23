<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine\Entity;

use App\Common\Infrastructure\Doctrine\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Order\Infrastructure\Doctrine\Repository\ClientUserRepository;
use \App\Order\Domain\Entity\ClientUser as DomainClientUser;

#[ORM\Entity(repositoryClass: ClientUserRepository::class)]
class ClientUser extends User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public static function fromDomain(DomainClientUser $client): ClientUser
    {
        $self = new self();

        $self->email = $client->email;
        $self->password = $client->password;
        $self->username = $client->username;
        $self->roles = $client->roles;
        $self->id = $client->id;

        return $self;
    }
}
