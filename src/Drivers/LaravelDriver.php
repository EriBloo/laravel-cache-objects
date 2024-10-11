<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Drivers;

use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\Contracts\CacheObjectDriver;
use Illuminate\Contracts\Cache\Store;

final class LaravelDriver implements CacheObjectDriver
{
    public function __construct(
        private readonly Store $repository,
    ) {}

    public function set(mixed $value, CacheObject $cacheObject): bool
    {
        $key = $this->prepareKey($cacheObject);
        $value = $this->prepareValue($value);
        $ttl = $this->prepareTtl($cacheObject);

        if ($ttl <= 0) {
            return $this->repository->forever($key, $value);
        }

        return $this->repository->put($key, $value, $ttl);
    }

    public function get(CacheObject $cacheObject): mixed
    {
        $key = $this->prepareKey($cacheObject);
        $value = $this->repository->get($key);

        if ($value === null) {
            return null;
        }

        return $this->prepareReturn($value);
    }

    public function delete(CacheObject $cacheObject): bool
    {
        return $this->repository->forget($this->prepareKey($cacheObject));
    }

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     */
    private function prepareKey(CacheObject $cacheObject): string
    {
        return $cacheObject->key();
    }

    private function prepareValue(mixed $value): string
    {
        return serialize($value);
    }

    private function prepareReturn(string $value): mixed
    {
        return unserialize($value);
    }

    /**
     * @template TValue
     *
     * @param CacheObject<TValue> $cacheObject
     */
    private function prepareTtl(CacheObject $cacheObject): int
    {
        return (int) $cacheObject->ttl()
            ->totalSeconds;
    }
}
