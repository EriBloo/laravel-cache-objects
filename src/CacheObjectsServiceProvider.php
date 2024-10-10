<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects;

use EriBloo\CacheObjects\Commands\CacheObjectsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CacheObjectsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-cache-objects')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_cache_objects_table')
            ->hasCommand(CacheObjectsCommand::class);
    }
}
