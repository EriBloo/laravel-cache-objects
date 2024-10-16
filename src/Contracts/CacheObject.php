<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

use Carbon\CarbonInterval;

/**
 * @template TValue
 */
interface CacheObject
{
    public function key(): Key;

    public function ttl(): CarbonInterval;

    /**
     * @return Transformer<TValue>
     */
    public function transformer(): Transformer;
}
