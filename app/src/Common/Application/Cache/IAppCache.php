<?php

declare(strict_types=1);

namespace App\Common\Application\Cache;

interface IAppCache
{
    public function get(string $key): ?string;

    public function remove(string ...$keys): void;

    public function set(string $key, string $value): void;

    public function isOff(): bool;
}