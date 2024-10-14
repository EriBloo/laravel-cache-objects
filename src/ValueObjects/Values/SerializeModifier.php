<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use EriBloo\CacheObjects\Contracts\CacheValueModifier;

/**
 * @template TValue
 *
 * @implements CacheValueModifier<TValue>
 */
final readonly class SerializeModifier implements CacheValueModifier
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
