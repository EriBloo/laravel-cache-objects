<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

interface HashedKey
{
    public function hashAlgo(): string;
}
