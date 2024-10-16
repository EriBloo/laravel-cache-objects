<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Drivers;

use EriBloo\CacheObjects\Contracts\CacheObject;
use EriBloo\CacheObjects\Events\CacheObjectDeleted;
use EriBloo\CacheObjects\Events\CacheObjectMissed;
use EriBloo\CacheObjects\Events\CacheObjectRetrieved;
use EriBloo\CacheObjects\Events\CacheObjectStored;
use Illuminate\Contracts\Cache\Store;
use EriBloo\CacheObjects\Contracts\CacheDriver as CacheDriverContract;

/**
 * @template TValue
 *
 * @implements CacheDriverContract<TValue>
 */
final class CacheDriver implements CacheDriverContract
{
    public function __construct(
        private readonly Store $store,
    ) {}

    public function set(mixed $value, CacheObject $cacheObject): string
    {
        $key = (string) $cacheObject->key();
        $transformed = $cacheObject->transformer()
            ->onSave($value);
        $ttl = (int) $cacheObject->ttl()
            ->total('seconds');

        if ($ttl <= 0) {
            $this->store->forever($key, $transformed);
        } else {
            $this->store->put($key, $transformed, $ttl);
        }

        event(new CacheObjectStored($cacheObject, $value, $transformed));

        return $key;
    }

    public function get(CacheObject $cacheObject): mixed
    {
        $key = (string) $cacheObject->key();
        $value = $this->store->get($key);

        if ($value === null) {
            event(new CacheObjectMissed($cacheObject));

            return null;
        }

        $transformed = $cacheObject->transformer()
            ->onLoad($value);

        event(new CacheObjectRetrieved($cacheObject, $value, $transformed));

        return $transformed;
    }

    public function delete(CacheObject $cacheObject): bool
    {
        $result = $this->store->forget((string) $cacheObject->key());

        if ($result === true) {
            event(new CacheObjectDeleted($cacheObject));
        }

        return $result;
    }
}
