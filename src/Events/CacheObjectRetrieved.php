<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Events;

use EriBloo\CacheObjects\Contracts\CacheObject;
use Illuminate\Queue\SerializesModels;

final readonly class CacheObjectRetrieved
{
    use SerializesModels;

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     * @param TValue $transformedValue
     */
    public function __construct(
        public CacheObject $cacheObject,
        public string $originalValue,
        public mixed $transformedValue,
    ) {}
}
