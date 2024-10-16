<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

use Carbon\CarbonInterval;

/**
 * @template TValue
 *
 * @extends SessionObject<TValue>
 */
interface CacheObject extends SessionObject
{
    public function ttl(): CarbonInterval;
}
