<?php

namespace App\Common\Infrastructure\Redis\Cache;

use App\Common\Application\Cache\AppCacheInterface;
use Redis;

final class RedisAppCache implements AppCacheInterface
{
    protected ?\Redis $redis;

    static ?self $instance = null;

    public function __invoke(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->initRedis();
    }

    public function get(string $key): ?string
    {
        $item = $this->redis->get($key);

        if (!$item) return null;

        return $item;
    }

    private function initRedis(): void
    {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379, 30);
        } catch (\RedisException $e) {
            $redis = null;
        } finally {
            $this->redis = $redis;
        }
    }

    public function remove(string ...$keys): void
    {
        if ($this->isOff()) return;

        $this->redis->del(...$keys);
    }

    public function set(string $key, string $value): void
    {
        $this->redis->setex(
            $key,
            3600,
            $value
        );
    }

    public function isOff(): bool
    {
        if (is_null($this->redis)) {
            return true;
        }

        if (!$this->redis->isConnected()) {
            $this->initRedis();
        }

        return $this->redis === null;
    }
}