<?php

declare(strict_types=1);

use EriBloo\CacheObjects\Tests\Fixtures\BasicCacheObject;
use EriBloo\CacheObjects\Tests\Fixtures\EncryptedCacheObject;
use EriBloo\CacheObjects\Tests\Fixtures\GuardCacheObject;
use EriBloo\CacheObjects\Tests\Fixtures\HashedCacheObject;
use EriBloo\CacheObjects\Tests\Fixtures\ObjectWithTime;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

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

it('deletes objects properly', function () {
    // prepare
    $obj = new BasicCacheObject('key');
    $obj->store('test');
    assertNotNull($obj->retrieve());

    // execute
    $obj->delete();

    // assert
    assertNull($obj->retrieve());
});

it('encrypts value properly', function () {
    // prepare
    $obj = new EncryptedCacheObject;

    // execute
    $obj->store('test');

    // assert
    assertEquals(serialize('test'), Crypt::decryptString(cache()->get((string) $obj->key())));
    assertEquals('test', $obj->retrieve());
});

it('guards on save properly', function () {
    // prepare
    $obj = new GuardCacheObject(function (ObjectWithTime $value) {
        if ($value->time->isFuture()) {
            throw new InvalidArgumentException();
        }
    }, null);

    // execute and assert
    $obj->store(new ObjectWithTime(now()->addHour()));
})->throws(InvalidArgumentException::class);

it('guards on load properly', function () {
    // prepare
    $obj = new GuardCacheObject(null, function ($value) {
        if ($value->time->isFuture()) {
            throw new InvalidArgumentException();
        }
    });
    $obj->store(value: new ObjectWithTime(now()->addHour()));

    // execute and assert
    $obj->retrieve();
})->throws(InvalidArgumentException::class);
