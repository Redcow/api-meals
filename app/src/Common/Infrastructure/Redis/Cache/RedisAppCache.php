<?php

namespace App\Common\Infrastructure\Redis\Cache;

use App\Common\Application\Cache\AppCacheInterface;
use Redis;

final readonly class RedisAppCache implements AppCacheInterface
{
    protected \Redis $redis;

    public function __construct() {
        $this->initRedis();
    }

    public function get(string $key): ?string
    {
        $item = $this->redis->get($key);

        if(!$item) return null;

        return $item;
    }

    public function cacheIt(string $key, string $value): void
    {
        $this->redis->set(
            $key,
            $value
        );
    }
    public function isOff(): bool
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

    public function remove(string ...$keys): void
    {
        if($this->isOff()) return;

        $this->redis->del(...$keys);
    }
}