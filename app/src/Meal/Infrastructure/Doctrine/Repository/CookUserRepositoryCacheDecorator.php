<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\IAppCache;
use App\Common\Infrastructure\Symfony\JsonEncoder\JsonSerializer;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;

final class CookUserRepositoryCacheDecorator
    extends CookUserRepositoryBaseDecorator
    implements ICookUserRepository
{
    private IAppCache $cache;

    public function __construct(
        ICookUserRepository $wrappee,
        IAppCache $cache
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

        return $this->cacheIt($cook);
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

        return $this->cacheIt($cook);
    }

    public function cacheIt(CookUser $cook): CookUser
    {
        $this->cache->set(
            "COOK:$cook->id",
            json_encode($cook)
        );

        return $cook;
    }
}