<?php

declare(strict_types=1);

use EriBloo\CacheObjects\Events\CacheObjectDeleted;
use EriBloo\CacheObjects\Events\CacheObjectMissed;
use EriBloo\CacheObjects\Events\CacheObjectRetrieved;
use EriBloo\CacheObjects\Events\CacheObjectStored;
use EriBloo\CacheObjects\Tests\Fixtures\BasicCacheObject;
use Illuminate\Support\Facades\Event;

it('dispatches stored event', function () {
    // prepare
    Event::fake();
    $obj = new BasicCacheObject('test');

    // execute
    $obj->store('test');

    // assert
    Event::assertDispatched(CacheObjectStored::class);
});

it('dispatches restored event', function () {
    // prepare
    Event::fake();
    $obj = new BasicCacheObject('test');
    $obj->store('test');

    // execute
    $obj->retrieve();

    // assert
    Event::assertDispatched(CacheObjectRetrieved::class);
});

it('dispatches missed event', function () {
    // prepare
    Event::fake();
    $obj = new BasicCacheObject('test');

    // execute
    $obj->retrieve();

    // assert
    Event::assertDispatched(CacheObjectMissed::class);
});

it('dispatches deleted event', function () {
    // prepare
    Event::fake();
    $obj = new BasicCacheObject('test');
    $obj->store('test');

    // execute
    $obj->delete();

    // assert
    Event::assertDispatched(CacheObjectDeleted::class);
});
