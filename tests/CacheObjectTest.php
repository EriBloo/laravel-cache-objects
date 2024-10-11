<?php

declare(strict_types=1);

use EriBloo\CacheObjects\Tests\Fixtures\BasicCacheObject;

use function PHPUnit\Framework\assertEquals;

it('stores basic cache object', function () {
    // prepare
    $obj = new BasicCacheObject('key');

    // execute
    $obj->store('test');

    // assert
    assertEquals('test', $obj->retrieve());
});
