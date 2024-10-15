<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Events;

use EriBloo\CacheObjects\Contracts\CacheObject;
use Illuminate\Queue\SerializesModels;

final readonly class CacheObjectDeleted
{
    use SerializesModels;

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     */
    public function __construct(
        public CacheObject $cacheObject,
    ) {}
}
