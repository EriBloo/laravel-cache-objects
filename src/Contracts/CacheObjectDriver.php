<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

interface CacheObjectDriver
{
    /**
     * @template TValue
     *
     * @param TValue $value
     * @param CacheObject<TValue> $cacheObject
     */
    public function set(mixed $value, CacheObject $cacheObject): bool;

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     * @return TValue|null
     */
    public function get(CacheObject $cacheObject): mixed;

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     */
    public function delete(CacheObject $cacheObject): bool;
}
