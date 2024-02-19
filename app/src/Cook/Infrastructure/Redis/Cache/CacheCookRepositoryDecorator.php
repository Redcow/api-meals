<?php

namespace App\Cook\Infrastructure\Redis\Cache;

use App\Common\Application\Cache\AppCacheInterface;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Repository\UserRepositoryInterface;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Domain\Repository\CookRepositoryBaseDecorator;
use App\Cook\Domain\Repository\CookRepositoryInterface;

final readonly class CacheCookRepositoryDecorator
    extends CookRepositoryBaseDecorator
    implements CookRepositoryInterface
{
    private AppCacheInterface $cache;

    public function __construct(
        UserRepositoryInterface $wrappee,
        AppCacheInterface $cache
    )
    {
        $this->cache = $cache;
        parent::__construct($wrappee);
    }

    /**
     * @param Cook $user
     * @return Cook
     */
    public function persist($user): Cook
    {
        if($this->cache->isOff()){
            return $this->wrappee->persist($user);
        }

        $cook = $this->wrappee->persist($user);

        if(!$this->cache->isOff())
        {
            $this->cache($cook);
        }

        return $cook;
    }

    public function cache(User $cook): void
    {
        $this->cache->cacheIt(
            "USER:$cook->id",
            json_encode($cook)
        );
    }
}