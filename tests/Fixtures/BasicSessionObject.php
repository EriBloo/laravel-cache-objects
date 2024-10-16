<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use EriBloo\CacheObjects\Concerns\SessionObjectActions;
use EriBloo\CacheObjects\Contracts\SessionObject;
use EriBloo\CacheObjects\ValueObjects\Keys\StringKey;
use EriBloo\CacheObjects\ValueObjects\Values\SerializeTransformer;

/**
 * @implements SessionObject<string>
 */
final class BasicSessionObject implements SessionObject
{
    /** @use SessionObjectActions<string> */
    use SessionObjectActions;

    public function __construct(
        private string $value,
    ) {}

    public function key(): StringKey
    {
        return new StringKey("basic-session-object:{$this->value}");
    }

    /**
     * @return SerializeTransformer<string>
     */
    public function transformer(): SerializeTransformer
    {
        return new SerializeTransformer();
    }
}
