<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Drivers;

use EriBloo\CacheObjects\Contracts\SessionDriver as SessionDriverContract;
use EriBloo\CacheObjects\Contracts\SessionObject;
use Illuminate\Contracts\Session\Session;

/**
 * @template TValue
 *
 * @implements SessionDriverContract<TValue>
 */
final readonly class SessionDriver implements SessionDriverContract
{
    public function __construct(
        private Session $session,
    ) {}

    public function set(mixed $value, SessionObject $sessionObject): string
    {
        $key = (string) $sessionObject->key();
        $transformed = $sessionObject->transformer()
            ->onSave($value);

        $this->session->put($key, $transformed);

        return $key;
    }

    public function get(SessionObject $sessionObject): mixed
    {
        $key = (string) $sessionObject->key();
        $value = $this->session->get($key);

        if ($value === null) {
            return null;
        }

        return $sessionObject->transformer()
            ->onLoad($value);
    }

    public function delete(SessionObject $sessionObject): bool
    {
        $key = (string) $sessionObject->key();

        $this->session->forget($key);

        return true;
    }
}
