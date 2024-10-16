<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use Crypt;
use EriBloo\CacheObjects\Contracts\Transformer;

/**
 * @template TValue
 *
 * @implements Transformer<TValue>
 */
final readonly class EncryptedTransformer implements Transformer
{
    /**
     * @param Transformer<TValue> $transformer
     */
    public function __construct(
        private Transformer $transformer,
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
