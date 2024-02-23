<?php

namespace App\Common\Application\Cache;

interface AppCacheInterface
{
    public function get(string $key): ?string;

    public function remove(string ...$keys): void;

    public function set(string $key, string $value): void;

    public function isOff(): bool;
}