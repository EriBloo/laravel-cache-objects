<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects;

use EriBloo\CacheObjects\Contracts\CacheKey;
use InvalidArgumentException;

final readonly class HashedKey implements CacheKey
{
    public function __construct(
        private CacheKey $key,
        private string $algo = 'sha256',
    ) {
        if (! in_array($this->algo, hash_algos(), true)) {
            throw new InvalidArgumentException("{$this->algo} is not a valid hashing algorithm");
        }
    }

    public function __toString(): string
    {
        return hash($this->algo, (string) $this->key);
    }
}
