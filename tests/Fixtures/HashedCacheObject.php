<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\ValueObjects\Keys\HashedKey;
use EriBloo\CacheObjects\ValueObjects\Keys\StringKey;
use EriBloo\CacheObjects\ValueObjects\Values\SerializeModifier;

/**
 * @implements CacheObject<string>
 */
final readonly class HashedCacheObject implements CacheObject
{
    /** @use CacheObjectActions<string> */
    use CacheObjectActions;

    public function key(): HashedKey
    {
        return new HashedKey(new StringKey('hashed-cache-object'));
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::seconds(0);
    }

    /**
     * @return SerializeModifier<string>
     */
    public function modifier(): SerializeModifier
    {
        return new SerializeModifier(false);
    }
}
