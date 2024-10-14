<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Concerns;

use EriBloo\CacheObjects\Contracts\CacheObjectDriver;

/**
 * @template TValue
 */
trait CacheObjectActions
{
    /**
     * @param TValue $value
     */
    public function store(mixed $value): string
    {
        /** @var CacheObjectDriver $driver */
        $driver = app()
            ->make(CacheObjectDriver::class);

        return $driver->set($value, $this);
    }

    /**
     * @return TValue|null
     */
    public function retrieve(): mixed
    {
        /** @var CacheObjectDriver $driver */
        $driver = app()
            ->make(CacheObjectDriver::class);

        return $driver->get($this);
    }

    public function delete(): bool
    {
        /** @var CacheObjectDriver $driver */
        $driver = app()
            ->make(CacheObjectDriver::class);

        return $driver->delete($this);
    }
}
