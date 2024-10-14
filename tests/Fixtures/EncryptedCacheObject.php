<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\ValueObjects\Keys\StringKey;
use EriBloo\CacheObjects\ValueObjects\Values\EncryptedModifier;
use EriBloo\CacheObjects\ValueObjects\Values\SerializeModifier;

/**
 * @implements CacheObject<string>
 */
final readonly class EncryptedCacheObject implements CacheObject
{
    /** @use CacheObjectActions<string> */
    use CacheObjectActions;

    public function key(): StringKey
    {
        return new StringKey('encrypted-cache-object');
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::seconds(0);
    }

    /**
     * @return EncryptedModifier<string>
     */
    public function modifier(): EncryptedModifier
    {
        return new EncryptedModifier(new SerializeModifier(false));
    }
}
