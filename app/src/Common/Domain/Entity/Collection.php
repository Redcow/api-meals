<?php

namespace App\Common\Domain\Entity;

use Closure;

/**
 * @template T
 */
class Collection implements \Iterator
{

    private int $position = 0;

    public function __construct(
        /**
         * @var T[]
         */
        private array $collection = []
    ) {}

    /**
     * @param T $element
     * @return void
     */
    public function add($element): void
    {
        $this->collection[] = $element;
    }

    /**
     * @param null|int $index
     * @return T|null|T[]
     */
    public function get(?int $index = null): mixed
    {
        if($index === null) {
            return $this->collection;
        }

        return $this->collection[$index] ?? null;
    }

    /**
     * @param callable(T): bool $callback
     * @return T|null
     */
    public function find(callable $callback): mixed
    {
        foreach ( $this->collection as $item )
        {
            if ($callback($item)) return $item;
        }
        return null;
    }

    public function filter(Closure $closure): array
    {
        $this->collection = array_filter(
            $this->collection,
            $closure
        );

        return $this->collection;
    }

    public function remove(int $index): void
    {
        array_splice($this->collection, $index, 1);
    }

    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @template T2
     * @param callable(T2, T): mixed $callback
     * @param T2 $initialValue
     * @return T2
     */
    public function reduce(callable $callback, $initialValue): mixed
    {
        return array_reduce(
            $this->collection,
            $callback,
            $initialValue
        );
    }

    /**
     * @param callable(T, T[]=): bool $callback
     * @return bool
     */
    public function every(callable $callback): bool
    {
        foreach ($this->collection as $item)
        {
            if(!$callback($item, $this->collection)) return false;
        }

        return true;
    }

    /**
     * @param callable(T, T[]=): T $callback
     * @return T[]
     */
    public function map(callable $callback): array
    {
        foreach ( $this->collection as $key => $item )
        {
            $this->collection[$key] = $callback($item);
        }

        return $this->collection;
    }
}