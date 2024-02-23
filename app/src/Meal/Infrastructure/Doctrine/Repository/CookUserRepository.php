<?php

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Meal\Domain\Entity\CookUser as DomainCookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;
use App\Meal\Infrastructure\Doctrine\Entity\CookUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<CookUser>
 * @implements PasswordUpgraderInterface<CookUser>
 *
 * @method CookUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CookUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CookUser[]    findAll()
 * @method CookUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CookUserRepository extends ServiceEntityRepository
    implements PasswordUpgraderInterface, CookUserRepositoryInterface
{
    private readonly UserPasswordHasherInterface $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, CookUser::class);
        $this->hasher = $hasher;
    }

    public function persist(DomainCookUser $cook): DomainCookUser
    {
        if($cook->id === null) {
            $dbUser = $this->persistNew($cook);
        } else {
            $dbUser = $this->persistChanges($cook);
            if ( $dbUser === null) {
                throw new \Exception("NOT FOUND");
                // TODO HANDLE EXCEPTION BETTER
            }
        }

        $this->getEntityManager()->persist($dbUser);
        $this->getEntityManager()->flush();

        return $cook->with(
            id: $dbUser->getId(),
            roles: $dbUser->getRoles()
        );
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof CookUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getById(int $id): DomainCookUser
    {
        $cookUser = $this->find($id);

        if ( $cookUser === null) {
            throw new \Exception("NOT FOUND");
            // TODO HANDLE EXCEPTION BETTER
        }

        return $cookUser->asDomain();
    }

    private function persistNew(DomainCookUser $cook): CookUser
    {
        $dbUser = CookUser::fromDomain($cook);

        $hashedPassword = $this->hasher->hashPassword(
            $dbUser,
            $cook->password
        );

        $dbUser->setPassword($hashedPassword);

        return $dbUser;
    }

    private function persistChanges(DomainCookUser $cook): ?CookUser
    {
        $dbCook = $this->find($cook->id);

        $dbCook->setUsername($cook->username);

        return $dbCook;
    }
}
