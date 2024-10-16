<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Contracts;

/**
 * @template TValue
 *
 * @extends CacheDriver<TValue>
 */
interface SessionDriver extends CacheDriver
{
    /**
     * @param TValue $value
     * @param SessionObject<TValue> $sessionObject
     */
    public function set(mixed $value, SessionObject $sessionObject): string;

    /**
     * @param SessionObject<TValue> $sessionObject
     *
     * @return TValue|null
     */
    public function get(SessionObject $sessionObject): mixed;

    /**
     * @param SessionObject<TValue> $sessionObject
     */
    public function delete(SessionObject $sessionObject): bool;
}
