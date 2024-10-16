<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

/**
 * @template TValue
 */
interface SessionObject
{
    public function key(): Key;

    /**
     * @return Transformer<TValue>
     */
    public function transformer(): Transformer;
}
