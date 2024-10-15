<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\ValueObjects\Keys\StringKey;
use EriBloo\CacheObjects\ValueObjects\Values\GuardTransformer;
use EriBloo\CacheObjects\ValueObjects\Values\SerializeTransformer;
use Closure;

/**
 * @template ObjectWithTime
 *
 * @implements CacheObject<ObjectWithTime>
 */
final class GuardCacheObject implements CacheObject
{
    use CacheObjectActions;

    public function __construct(
        private Closure|null $onSaveGuard,
        private Closure|null $onLoadGuard,
    ) {}

    public function key(): StringKey
    {
        return new StringKey('guard-cache-object');
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::seconds(0);
    }

    /**
     * @return GuardTransformer<ObjectWithTime>
     */
    public function transformer(): GuardTransformer
    {
        return new GuardTransformer(new SerializeTransformer(), $this->onSaveGuard, $this->onLoadGuard);
    }
}
