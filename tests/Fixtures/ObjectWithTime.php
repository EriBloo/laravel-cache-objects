<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests\Fixtures;

use Carbon\CarbonInterface;

final readonly class ObjectWithTime
{
    public function __construct(
        public CarbonInterface $time,
    ) {}
}
