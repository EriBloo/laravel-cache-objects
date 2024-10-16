<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Concerns;

use EriBloo\CacheObjects\Contracts\SessionDriver;

/**
 * @template TValue
 */
trait SessionObjectActions
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

    /**
     * @return SessionDriver<TValue>
     */
    protected function resolveDriver(): SessionDriver
    {
        return app()->make('session-driver');
    }
}
