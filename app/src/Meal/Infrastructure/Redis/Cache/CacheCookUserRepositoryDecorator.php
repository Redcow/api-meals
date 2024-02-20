<?php

namespace App\Meal\Infrastructure\Redis\Cache;

use App\Common\Application\Cache\AppCacheInterface;
use App\Common\Infrastructure\Symfony\JsonEncoder\JsonSerializer;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryBaseDecorator;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;

final readonly class CacheCookUserRepositoryDecorator
    extends CookUserRepositoryBaseDecorator
    implements CookUserRepositoryInterface
{
    private AppCacheInterface $cache;

    public function __construct(
        CookUserRepositoryInterface $wrappee,
        AppCacheInterface $cache
    )
    {
        $this->cache = $cache;
        parent::__construct($wrappee);
    }

    public function persist(CookUser $cook): CookUser
    {
        if($this->cache->isOff()){
            return $this->wrappee->persist($cook);
        }

        $cook = $this->wrappee->persist($cook);

        if(!$this->cache->isOff())
        {
            $this->cacheIt($cook);
        }

        return $cook;
    }

    public function getById(int $id): CookUser
    {
        if($this->cache->isOff()){
            return $this->wrappee->getById($id);
        }

        if($json = $this->cache->get('COOK:'.$id)){
            $serializer = JsonSerializer::get();

            return $serializer->deserialize(
                $json,
                CookUser::class
            );
        }

        $cook = $this->wrappee->getById($id);

        $this->cacheIt($cook);

        return $cook;
    }

    public function cacheIt(CookUser $cook): void
    {
        $this->cache->cacheIt(
            "COOK:$cook->id",
            json_encode($cook)
        );
    }
}