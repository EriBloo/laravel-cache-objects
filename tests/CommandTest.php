<?php

declare(strict_types=1);

it('runs command without error', function () {
    $this->artisan('make:cache-object TestCacheObject')
        ->assertSuccessful();
});
