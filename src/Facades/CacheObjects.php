<?php

namespace EriBloo\CacheObjects\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EriBloo\CacheObjects\CacheObjects
 */
class CacheObjects extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \EriBloo\CacheObjects\CacheObjects::class;
    }
}
