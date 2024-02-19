<?php

namespace App\Common\Infrastructure\Doctrine\Repository;

use App\Common\Domain\Entity\User as DomainUser;
use App\Common\Domain\Repository\UserRepositoryInterface;
use App\Common\Infrastructure\Doctrine\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
    implements PasswordUpgraderInterface,
    UserRepositoryInterface
{
    private readonly UserPasswordHasherInterface $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, User::class);
        $this->hasher = $hasher;
    }

    public function persist($user): DomainUser
    {
        $dbUser = User::fromDomain($user);

        $hashedPassword = $this->hasher->hashPassword(
            $dbUser,
            $user->password
        );

        $dbUser->setPassword($hashedPassword);

        $this->getEntityManager()->persist($dbUser);
        $this->getEntityManager()->flush();

        return $user->with(id: $dbUser->getId());
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

}
