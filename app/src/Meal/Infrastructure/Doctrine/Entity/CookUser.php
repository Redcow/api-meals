<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Entity;

use App\Meal\Domain\Entity\CookUser as DomainCookUser;

use App\Common\Infrastructure\Doctrine\Entity\User;
use App\Meal\Infrastructure\Doctrine\Repository\CookUserRepository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CookUserRepository::class)]
class CookUser extends User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\OneToMany(targetEntity: Meal::class, mappedBy: 'cook', orphanRemoval: true)]
    private Collection $meals;

    public static function fromDomain(DomainCookUser $client): CookUser
    {
        $self = new self();

        $self->email = $client->email;
        $self->password = $client->password;
        $self->username = $client->username;
        $self->roles = $client->roles;
        $self->id = $client->id;

        return $self;
    }

    public function asDomain(): DomainCookUser
    {
        return new DomainCookUser(
            email: $this->email,
            password: $this->password,
            username: $this->username,
            roles: $this->roles,
            id: $this->id
        );
    }

    /**
     * @return Collection<int, Meal>
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): static
    {
        if (!$this->meals->contains($meal)) {
            $this->meals->add($meal);
            $meal->setCook($this);
        }

        return $this;
    }

    public function removeMeal(Meal $meal): static
    {
        if ($this->meals->removeElement($meal)) {
            // set the owning side to null (unless already changed)
            if ($meal->getCook() === $this) {
                $meal->setCook(null);
            }
        }

        return $this;
    }
}
