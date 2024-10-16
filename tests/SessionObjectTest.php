<?php

declare(strict_types=1);

use EriBloo\CacheObjects\Tests\Fixtures\BasicSessionObject;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

it('stores basic cache object', function () {
    // prepare
    $obj = new BasicSessionObject('key');

    // execute
    $obj->store('test');

    // assert
    assertEquals('test', $obj->retrieve());
});

it('deletes objects properly', function () {
    // prepare
    $obj = new BasicSessionObject('key');
    $obj->store('test');
    assertNotNull($obj->retrieve());

    // execute
    $obj->delete();

    // assert
    assertNull($obj->retrieve());
});
