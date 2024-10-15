<?php

declare(strict_types=1);

namespace EriBloo\CacheObjects\Tests;

use Cache;
use Config;
use EriBloo\CacheObjects\CacheObjectsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'EriBloo\\CacheObjects\\Database\\Factories\\' . class_basename(
                $modelName,
            ) . 'Factory',
        );

        Cache::setDefaultDriver('array');
        Config::set('app.key', random_bytes(32));
        Config::set('app.cipher', 'aes-256-cbc');
    }

    protected function getPackageProviders($app)
    {
        return [CacheObjectsServiceProvider::class];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-cache-objects_table.php.stub';
        $migration->up();
        */
    }
}
