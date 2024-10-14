<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use Crypt;
use EriBloo\CacheObjects\Contracts\CacheValueModifier;

/**
 * @template TValue
 *
 * @implements CacheValueModifier<TValue>
 */
final readonly class EncryptedModifier implements CacheValueModifier
{
    /**
     * @param CacheValueModifier<TValue> $modifier
     */
    public function __construct(
        private CacheValueModifier $modifier,
    ) {}

    public function onLoad(string $value): mixed
    {
        return $this->modifier->onLoad(Crypt::decryptString($value));
    }

    public function onSave(mixed $value): string
    {
        return Crypt::encryptString($this->modifier->onSave($value));
    }
}
