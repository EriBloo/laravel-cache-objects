<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects;

use EriBloo\CacheObjects\Commands\MakeCacheObject;
use EriBloo\CacheObjects\Contracts\CacheObjectDriver;
use EriBloo\CacheObjects\Drivers\LaravelDriver;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Foundation\Application;
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
            ->hasCommand(MakeCacheObject::class);

        $this->app->scoped(CacheObjectDriver::class, function (Application $app) {
            return new LaravelDriver($app->make(Store::class));
        });
    }
}
