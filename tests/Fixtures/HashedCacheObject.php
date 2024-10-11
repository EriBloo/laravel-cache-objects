<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\Contracts\HashedKey;

/**
 * @implements CacheObject<string>
 */
final readonly class HashedCacheObject implements CacheObject, HashedKey
{
    use CacheObjectActions;

    public function key(): string
    {
        return 'hashed-cache-object';
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::seconds(0);
    }

    public function hashAlgo(): string
    {
        return 'sha256';
    }
}
