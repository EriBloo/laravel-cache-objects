<?php

namespace EriBloo\CacheObjects\Commands;

use Illuminate\Console\Command;

class CacheObjectsCommand extends Command
{
    public $signature = 'laravel-cache-objects';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
