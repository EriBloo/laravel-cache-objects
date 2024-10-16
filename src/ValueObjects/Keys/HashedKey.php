<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Keys;

use EriBloo\CacheObjects\Contracts\Key;
use InvalidArgumentException;

final readonly class HashedKey implements Key
{
    public function __construct(
        private Key $key,
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
