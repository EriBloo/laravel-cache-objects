<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Concerns;

use EriBloo\CacheObjects\Contracts\CacheObjectDriver;

/**
 * @template TValue
 */
trait CacheObjectActions
{
    public static function make(mixed ...$arguments): static
    {
        return new static(...$arguments); //@phpstan-ignore-line
    }

    /**
     * @param TValue $value
     */
    public function store(mixed $value): string
    {
        return $this->resolveDriver()
            ->set($value, $this);
    }

    /**
     * @return TValue|null
     */
    public function retrieve(): mixed
    {
        return $this->resolveDriver()
            ->get($this);
    }

    public function delete(): bool
    {
        return $this->resolveDriver()
            ->delete($this);
    }

    protected function resolveDriver(): CacheObjectDriver
    {
        return app()->make(CacheObjectDriver::class);
    }
}
