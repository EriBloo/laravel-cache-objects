<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects;

use EriBloo\CacheObjects\Commands\MakeCacheObject;
use EriBloo\CacheObjects\Drivers\CacheDriver;
use EriBloo\CacheObjects\Drivers\SessionDriver;
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
            ->hasCommand(MakeCacheObject::class)
            ->hasConfigFile();

        $this->app->scoped('cache-driver', function (Application $app): CacheDriver {
            return new CacheDriver($app->make('cache')->getStore());
        });

        $this->app->scoped('session-driver', function (Application $app): SessionDriver {
            return new SessionDriver($app->make('session')->driver());
        });
    }
}
