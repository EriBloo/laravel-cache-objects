<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Keys;

use EriBloo\CacheObjects\Contracts\Key;

final readonly class StringKey implements Key
{
    public function __construct(
        private string $key,
    ) {}

    public function __toString(): string
    {
        return $this->key;
    }
}
