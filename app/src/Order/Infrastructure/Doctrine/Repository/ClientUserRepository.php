<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

use App\Order\Domain\Repository\IClientUserRepository;
use \App\Order\Domain\Entity\ClientUser as DomainClientUser;
use App\Order\Infrastructure\Doctrine\Entity\ClientUser;

/**
 * @extends ServiceEntityRepository<ClientUser>
 *
 * @implements PasswordUpgraderInterface<ClientUser>
 *
 * @method ClientUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientUser[]    findAll()
 * @method ClientUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientUserRepository extends ServiceEntityRepository
    implements PasswordUpgraderInterface, IClientUserRepository
{
    private readonly UserPasswordHasherInterface $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, ClientUser::class);
        $this->hasher = $hasher;
    }

    public function persist(DomainClientUser $client): DomainClientUser
    {
        $dbClient = ClientUser::fromDomain($client);

        $hashedPassword = $this->hasher->hashPassword(
            $dbClient,
            $client->password
        );

        $dbClient->setPassword($hashedPassword);

        $this->getEntityManager()->persist($dbClient);
        $this->getEntityManager()->flush();

        return $client->with(
            id: $dbClient->getId(),
            roles: $dbClient->getRoles()
        );
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof ClientUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return ClientUser[] Returns an array of ClientUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClientUser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
