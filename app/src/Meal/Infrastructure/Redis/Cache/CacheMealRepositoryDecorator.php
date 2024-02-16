<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Redis\Cache;

use App\Common\Infrastructure\Symfony\JsonEncoder\JsonSerializer;

use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryBaseDecorator;
use App\Meal\Domain\Repository\MealRepositoryInterface;

use Redis;

class CacheMealRepositoryDecorator extends MealRepositoryBaseDecorator
{
    private readonly ?Redis $redis;

    public function __construct(MealRepositoryInterface $wrappee)
    {
        $this->initRedis();
        parent::__construct($wrappee);
    }

    public function persist(Meal $meal): Meal
    {
        if($this->redisOff()){
            return $this->wrappee->persist($meal);
        }

        return $this->cacheIt(
            $this->wrappee->persist($meal)
        );
    }

    public function getOne(int $id): Meal
    {
        if ($this->redisOff()){
            return $this->wrappee->getOne($id);
        }

        if($json = $this->redis->get("Meal:$id")) {

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

        if ($this->redisOff()){
            return;
        }

        $this->redis->del(
            array_map(fn (string $id) => "Meal:$id", $ids)
        );
    }

    private function cacheIt(Meal $meal): Meal
    {
        $this->redis->set(
            "Meal:$meal->id",
            json_encode($meal)
        );

        return $meal;
    }

    private function redisOff(): bool
    {
        if(is_null($this->redis)) {
            return true;
        }

        if(!$this->redis->isConnected()) {
            $this->initRedis();
        }

        return $this->redis === null;
    }

    private function initRedis(): void
    {
        try {
            $redis = new Redis();
            $redis->connect('redis');
        } catch (\RedisException $e) {
            $redis = null;
        } finally {
            $this->redis = $redis;
        }
    }
}