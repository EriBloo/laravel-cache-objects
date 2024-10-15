<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use EriBloo\CacheObjects\Contracts\CacheValueTransformer;

/**
 * @template TValue
 *
 * @implements CacheValueTransformer<TValue>
 */
final readonly class JsonTransformer implements CacheValueTransformer
{
    /**
     * @param int<1, max> $depth
     */
    public function __construct(
        private int $loadFlags = 0,
        private int $saveFlags = 0,
        private int $depth = 512,
    ) {}

    public function onLoad(string $value): mixed
    {
        return json_decode($value, null, $this->depth, JSON_THROW_ON_ERROR | $this->loadFlags);
    }

    public function onSave(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR | $this->saveFlags, $this->depth);
    }
}
