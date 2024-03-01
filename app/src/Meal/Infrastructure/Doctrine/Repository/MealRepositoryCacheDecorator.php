<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\IAppCache;
use App\Common\Domain\Entity\Collection;
use App\Common\Infrastructure\Symfony\JsonEncoder\JsonSerializer;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\IMealRepository;

class MealRepositoryCacheDecorator
    extends MealRepositoryBaseDecorator
    implements IMealRepository
{
    private readonly IAppCache $cache;

    public function __construct(IMealRepository $wrappee, IAppCache $cache)
    {
        $this->cache = $cache;
        parent::__construct($wrappee);
    }

    public function persist(Meal $meal): Meal
    {
        if($this->cache->isOff()) {
            return $this->wrappee->persist($meal);
        }

        $savedMeal = $this->wrappee->persist($meal);

        return $this->cacheIt($savedMeal);
    }

    public function getOne(int $id): Meal
    {
        if ($this->cache->isOff()){
            return $this->wrappee->getOne($id);
        }

        if($json = $this->cache->get("MEAL:$id")) {

            $serializer = JsonSerializer::get();

            return $serializer->deserialize(
                $json,
                Meal::class
            );
        }

        return $this->cacheIt(
            $this->wrappee->getOne($id)
        );
    }

    public function delete(int ...$ids): void
    {
        $this->wrappee->delete(...$ids);

        if ($this->cache->isOff()){
            return;
        }

        $this->cache->remove(...array_map(fn (string $id) => "MEAL:$id", $ids));
    }

    public function getAll(int ...$ids): Collection
    {
        /** @var Collection<Meal> $mealCollection */
        $mealCollection = new Collection();
        foreach ($ids as $id)
        {
            $meal = $this->getOne($id);
            $mealCollection->add($meal);
        }

        return $mealCollection;
    }

    private function cacheIt(Meal $meal): Meal
    {
        $this->cache->set(
            "MEAL:$meal->id",
            json_encode($meal)
        );

        return $meal;
    }

}