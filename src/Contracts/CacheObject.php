<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

use Carbon\CarbonInterval;

/**
 * @template TValue
 */
interface CacheObject
{
    public function key(): CacheKey;

    public function ttl(): CarbonInterval;

    /**
     * @param TValue $value
     */
    public function store(mixed $value): string;

    /**
     * @return TValue
     */
    public function retrieve(): mixed;
}
