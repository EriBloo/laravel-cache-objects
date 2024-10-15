<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use Crypt;
use EriBloo\CacheObjects\Contracts\CacheValueTransformer;

/**
 * @template TValue
 *
 * @implements CacheValueTransformer<TValue>
 */
final readonly class EncryptedTransformer implements CacheValueTransformer
{
    /**
     * @param CacheValueTransformer<TValue> $transformer
     */
    public function __construct(
        private CacheValueTransformer $transformer,
    ) {}

    public function onLoad(string $value): mixed
    {
        return $this->transformer->onLoad(Crypt::decryptString($value));
    }

    public function onSave(mixed $value): string
    {
        return Crypt::encryptString($this->transformer->onSave($value));
    }
}
