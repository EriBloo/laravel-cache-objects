<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterval;
use EriBloo\CacheObjects\Concerns\CacheObjectActions;
use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\ValueObjects\Keys\StringKey;
use EriBloo\CacheObjects\ValueObjects\Values\EncryptedTransformer;
use EriBloo\CacheObjects\ValueObjects\Values\SerializeTransformer;

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
     * @return EncryptedTransformer<string>
     */
    public function transformer(): EncryptedTransformer
    {
        return new EncryptedTransformer(new SerializeTransformer(false));
    }
}
