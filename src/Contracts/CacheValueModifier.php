<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

/**
 * @template T
 */
interface CacheValueModifier
{
    /**
     * @return T
     */
    public function onLoad(string $value): mixed;

    /**
     * @param T $value
     */
    public function onSave(mixed $value): string;
}
