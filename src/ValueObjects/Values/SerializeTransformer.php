<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use EriBloo\CacheObjects\Contracts\Transformer;

/**
 * @template TValue
 *
 * @implements Transformer<TValue>
 */
final readonly class SerializeTransformer implements Transformer
{
    /**
     * @param class-string[]|bool $allowedClasses
     */
    public function __construct(
        private array|bool $allowedClasses = true,
    ) {}

    public function onLoad(string $value): mixed
    {
        return unserialize($value, [
            'allowed_classes' => $this->allowedClasses,
        ]);
    }

    public function onSave(mixed $value): string
    {
        return serialize($value);
    }
}
