<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;

/**
 * @implements CacheObject<string>
 */
final readonly class BasicCacheObject implements CacheObject
{
    /** @use CacheObjectActions<string> */
    use CacheObjectActions;

    public function __construct(
        public string $value,
    ) {}

    public function key(): string
    {
        return "basic-cache-object:{$this->value}";
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::seconds(0);
    }
}
