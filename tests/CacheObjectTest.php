<?php

declare(strict_types=1);

use EriBloo\CacheObjects\Tests\Fixtures\BasicCacheObject;
use EriBloo\CacheObjects\Tests\Fixtures\HashedCacheObject;

use function PHPUnit\Framework\assertEquals;

it('stores basic cache object', function () {
    // prepare
    $obj = new BasicCacheObject('key');

    // execute
    $obj->store('test');

    // assert
    assertEquals('test', $obj->retrieve());
});

it('hashes key while storing', function () {
    // prepare
    $obj = new HashedCacheObject;

    // execute
    $key = $obj->store('test');

    // assert
    assertEquals(hash('sha256', 'hashed-cache-object'), $key);
    assertEquals('test', $obj->retrieve());
});
