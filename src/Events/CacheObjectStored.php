<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Events;

use EriBloo\CacheObjects\Contracts\CacheObject;
use Illuminate\Queue\SerializesModels;

final readonly class CacheObjectStored
{
    use SerializesModels;

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     * @param TValue $originalValue
     */
    public function __construct(
        public CacheObject $cacheObject,
        public mixed $originalValue,
        public string $transformedValue,
    ) {}
}
