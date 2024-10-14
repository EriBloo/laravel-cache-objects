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
     * @return CacheValueModifier<TValue>
     */
    public function modifier(): CacheValueModifier;
}
