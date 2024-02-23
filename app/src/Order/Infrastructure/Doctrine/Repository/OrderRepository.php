<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine\Repository;


use App\Order\Infrastructure\Doctrine\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Order\Infrastructure\Doctrine\Entity\Order;

use App\Order\Domain\Entity\Order as DomainOrder;
use App\Order\Domain\Entity\Article as DomainArticle;
use App\Order\Domain\Repository\OrderRepositoryInterface;


/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function persist(DomainOrder $order): DomainOrder
    {
        $dbOrder = Order::fromDomain($order);

        $dbOrder->setArticles(
            ...array_map(
                fn (DomainArticle $article) => Article::fromDomain($article),
                $order->articles->get()
            )
        );

        $this->getEntityManager()->persist($dbOrder);
        $this->getEntityManager()->flush();

        return $order->with(
            id: $dbOrder->getId()
        );
    }
//    /**
//     * @return Basket[] Returns an array of Basket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Basket
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
