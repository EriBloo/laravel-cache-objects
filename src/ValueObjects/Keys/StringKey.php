<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Keys;

use EriBloo\CacheObjects\Contracts\CacheKey;

final readonly class StringKey implements CacheKey
{
    public function __construct(
        private string $key,
    ) {}

    public function __toString(): string
    {
        return $this->key;
    }
}
