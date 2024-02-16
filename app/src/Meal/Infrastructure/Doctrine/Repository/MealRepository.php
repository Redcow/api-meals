<?php

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Meal\Domain\Entity\Meal as DomainMeal;
use App\Meal\Domain\Repository\MealRepositoryInterface;
use App\Meal\Infrastructure\Doctrine\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meal>
 *
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository implements MealRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    public function persist(DomainMeal $meal): DomainMeal
    {
        $dbMeal = Meal::fromDomain($meal);

        $this->getEntityManager()->persist($dbMeal);
        $this->getEntityManager()->flush();

        return $meal->with(id: $dbMeal->getId());
    }

    public function getOne(int $id): DomainMeal
    {
        $meal = $this->find($id);

        if(is_null($meal)) {
            throw new \Exception("NOT FOUND");
            // TODO HANDLE EXCEPTION BETTER
        }

        return new DomainMeal(
            $meal->getName(),
            $meal->getPrice(),
            $meal->getId()
        );
    }

    public function delete(int ...$ids): void
    {
        $meals = $this->findBy(
            ['id' => $ids]
        );

        foreach ($meals as $meal) {
            $this->getEntityManager()->remove($meal);
        }

        $this->getEntityManager()->flush();
    }
}
