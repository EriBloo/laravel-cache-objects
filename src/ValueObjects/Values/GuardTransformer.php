<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\ValueObjects\Values;

use EriBloo\CacheObjects\Contracts\Transformer;
use Closure;

/**
 * @template TValue
 *
 * @implements Transformer<TValue>
 */
final readonly class GuardTransformer implements Transformer
{
    /**
     * @param Transformer<TValue> $transformer
     * @param (Closure(TValue): void)|null $onSaveGuard
     * @param (Closure(TValue): void)|null $onLoadGuard
     */
    public function __construct(
        private Transformer $transformer,
        private Closure|null $onSaveGuard = null,
        private Closure|null $onLoadGuard = null,
    ) {}

    public function onLoad(string $value): mixed
    {
        $transformed = $this->transformer->onLoad($value);

        if ($this->onLoadGuard !== null) {
            call_user_func($this->onLoadGuard, $transformed);
        }

        return $transformed;
    }

    public function onSave(mixed $value): string
    {
        if ($this->onSaveGuard !== null) {
            call_user_func($this->onSaveGuard, $value);
        }

        return $this->transformer->onSave($value);
    }
}
