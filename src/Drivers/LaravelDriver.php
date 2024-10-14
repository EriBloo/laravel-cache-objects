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

    public function set(mixed $value, CacheObject $cacheObject): string
    {
        $key = (string) $cacheObject->key();
        $value = $cacheObject->modifier()
            ->onSave($value);
        $ttl = (int) $cacheObject->ttl()
->totalSeconds;

        if ($ttl <= 0) {
            $this->repository->forever($key, $value);
        } else {
            $this->repository->put($key, $value, $ttl);
        }

        return $key;
    }

    public function get(CacheObject $cacheObject): mixed
    {
        $key = (string) $cacheObject->key();
        $value = $this->repository->get($key);

        if ($value === null) {
            return null;
        }

        return $cacheObject->modifier()
            ->onLoad($value);
    }

    public function delete(CacheObject $cacheObject): bool
    {
        return $this->repository->forget((string) $cacheObject->key());
    }
}
