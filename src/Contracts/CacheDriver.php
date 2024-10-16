<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

/**
 * @template TValue
 */
interface CacheDriver
{
    /**
     * @param TValue $value
     * @param CacheObject<TValue> $cacheObject
     */
    public function set(mixed $value, CacheObject $cacheObject): string;

    /**
     * @param CacheObject<TValue> $cacheObject
     *
     * @return TValue|null
     */
    public function get(CacheObject $cacheObject): mixed;

    /**
     * @param CacheObject<TValue> $cacheObject
     */
    public function delete(CacheObject $cacheObject): bool;
}
