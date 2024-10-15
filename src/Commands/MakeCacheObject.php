<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('make:cache-object')]
class MakeCacheObject extends GeneratorCommand
{
    protected $name = 'make:cache-object';

    protected $type = 'CacheObject';

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/cache-object.stub');
    }

    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return config('cache-objects.namespace') ?: "{$rootNamespace}\Cache";
    }
}
