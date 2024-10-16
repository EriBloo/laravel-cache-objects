# Strongly typed cache objects

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eribloo/laravel-cache-objects.svg?style=flat-square)](https://packagist.org/packages/eribloo/laravel-cache-objects)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/eribloo/laravel-cache-objects/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/eribloo/laravel-cache-objects/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/eribloo/laravel-cache-objects/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/eribloo/laravel-cache-objects/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/eribloo/laravel-cache-objects.svg?style=flat-square)](https://packagist.org/packages/eribloo/laravel-cache-objects)

Introducing Laravel package that simplifies cache management by allowing you to encapsulate all details in one place. Improve your application cache maintanance with less raw strings and static typing.

```php
/**
 * @implements CacheObject<CarbonInterface>
 *
 * @method static self make(User $user)
 */
final readonly class SomeUserCache implements CacheObject
{
    /** @use CacheObjectActions<CarbonInterface> */
    use CacheObjectActions;

    public function __construct(
        public User $user,
    ) {}

    public function key(): StringKey
    {
        $id = $this->user->getKey();

        return new StringKey("some-cache:$id");
    }

    public function ttl(): CarbonInterval
    {
        return CarbonInterval::minutes(15);
    }

    /**
     * @return SerializeTransformer<CarbonInterface>
     */
    public function transformer(): SerializeTransformer
    {
        return new SerializeTransformer();
    }
}
```

You can later use this object to interract with cache:

```php

$user = User::findOrFail(1);

$key  = SomeUserCache::make($user)->store(now());  // 'some-cache:1'
$date = SomeUserCache::make($user)->retrieve();    // App\Support\Carbon object
$bool = SomeUserCache::make($user)->delete();      // true
```

## Table of contents

- [Installation](#installation)
- [Usage](#usage)
  - [Creating](#creating)
  - [CacheObject](#cacheobject)
  - [Key](#key)
    - [StringKey](#stringkey)
    - [HashedKey](#hashedkey)
  - [Time-to-live](#time-to-live)
  - [Transformer](#transformer)
    - [JsonTransformer](#jsontransformer)
    - [SerializeTransformer](#serializetransformer)
    - [EncryptedTransformer](#encryptedtransformer)
    - [GuardTransformer](#guardtransformer)
  - [Traits](#traits)
    - [CacheObjectActions](#cacheobjectactions)
  - [Driver](#driver)
    - [CacheDriver](#cachedriver)
  - [Events](#events)
    - [CacheObjectStored](#cacheobjectstored)
    - [CacheObjectRetrieved](#cacheobjectretrieved)
    - [CacheObjectMissed](#cacheobjectmissed)
    - [CacheObjectDeleted](#cacheobjectdeleted)
- [Extending](#extending)
- [PHPStan](#phpstan)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [Licence](#license)

## Installation

You can install the package via composer:

```bash
composer require eribloo/laravel-cache-objects
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="cache-objects-config"
```

This is the contents of the published config file:
```php
return [
    'namespace' => 'App\Cache',
];
```

## Usage

### Creating

You can create basic Cache Object by running Artisan Command:

```bash
php artisan make:cache-object SomeCacheObject
```

this will create class implementing `EriBloo\CacheObjects\Contracts\CacheObject` in namespace specified in config with some defaults for you to configure.

### CacheObject

`EriBloo\CacheObjects\Contracts\CacheObject` interface requires you to implement 3 methods:

```php
public function key(): EriBloo\CacheObjects\Contracts\Key;
public function ttl(): Carbon\CarbonInterval;
public function transformer(): EriBloo\CacheObjects\Contracts\Transformer;
```

### Key

Key interface is a wrapper for Stringable interface responsible for preparing key for storage. Currently 2 options exist.

##### StringKey

Basic key that accepts string.

```php
public function key(): EriBloo\CacheObjects\ValueObjects\Keys\StringKey
{
    return new StringKey(key: 'some-cache');
}
```

##### HashedKey

Decorator for other keys that returns hashes key before storage. Accepts optional algorithm in constructor (`sha256` by default).

```php
public function key(): EriBloo\CacheObjects\ValueObjects\Keys\HashedKey
{
    return new HashedKey(
        key: new StringKey('some-cache'), 
        algo: 'md5',
    );
}
```

### Time-to-live

Defined with `Carbon\CarbonInterval`. Values that resolve to 0 or less seconds are considered to be stored forever.

### Transformer

Transformers are classes responsible for modifying values before storage and after retrieval.

##### JsonTransformer

Uses `json_encode` on save and `json_decode` on load. Accepts optional flags and depth in constructor.

```php
public function transformer(): EriBloo\CacheObjects\ValueObjects\Values\JsonTransformer
{
    return new JsonTransformer(
        loadFlags: JSON_INVALID_UTF8_SUBSTITUTE,
        saveFlags: JSON_UNESCAPED_UNICODE,
        depth: 256,
    );
}
```

##### SerializeTransformer

Transformer that uses PHP `serialize` on save and `unserialize` on load. Accepts optional `class-string[]|bool` in constructor to specify classes allowed for deserialization.

```php
public function transformer(): EriBloo\CacheObjects\ValueObjects\Values\SerializeTransformer
{
    return new SerializeTransformer(allowedClasses: [SomeClass::class]);
}
```

##### EncryptedTransformer

Decorator for other transformer that uses `Crypt::encryptString` on save and `Crypt::decryptString` on load.

```php
public function transformer(): EriBloo\CacheObjects\ValueObjects\Values\EncryptedTransformer
{
    return new EncryptedTransformer(
        transformer: new SerializeTransformer,
    );
}
```

##### GuardTransformer

Proxy for other transformer that doesn't modify values, but instead validates them before storage or after retrieval. This class accepts up to 2 closures that should throw an Exception when provided value is invalid.

```php
public function transformer(): EriBloo\CacheObjects\ValueObjects\Values\GuardTransformer
{
    return new GuardTransformer(
        transformer: new EncryptedTransformer(new SerializeTransformer),
        onSaveGuard: function (CarbonInterface $value) {
            if ($value->isPast()) {
                throw new UnexpectedValueException;
            }
        },
        onLoadGuard: null,
    );
}
```

### Traits

##### CacheObjectActions

Optional (but helpful) trait that adds usage methods:

```php
public static function make(): static; // easier creation
public function store(mixed $value): string; // put into storage, returns key stored in cache
public function retrieve(): mixed; // get from storage
public function delete(): bool; // remove from storage
protected function resolveDriver(): EriBloo\CacheObjects\Contracts\Driver; // resolves to default driver from Service Provider, more below
```

### Driver

This interface defines methods used for interacting with storage. Currently 1 class exists.

##### CacheDriver

This class is a default driver that accepts an instance of `Illuminate\Contracts\Cache\Store`. Binding defined in Service Provider resolves this to your default cache storage.

### Events

Default driver dispatches events:

##### CacheObjectStored

When object is put in storage.

```php
final class CacheObjectStored
{
    public function __construct(
        public CacheObject $cacheObject,
        public mixed $originalValue,
        public string $transformedValue,
    ) {}
}
```

##### CacheObjectRetrieved

When object is retrieved from storage.

```php
final class CacheObjectRetrieved
{
    public function __construct(
        public CacheObject $cacheObject,
        public string $originalValue,
        public mixed $transformedValue,
    ) {}
}
```

##### CacheObjectMissed

When cache object retrieval misses.

```php
final class CacheObjectMissed
{
    public function __construct(
        public CacheObject $cacheObject,
    ) {}
}
```

##### CacheObjectDeleted

When cache object is removed from storage.

```php
final class CacheObjectDeleted
{
    public function __construct(
        public CacheObject $cacheObject,
    ) {}
}
```

## Extending

I created this package with ease of configuration in mind so you can easly create `Key`, `Transformer` or `Driver` that will suit your needs. Additionally if you have any ideas of classes that could be incorporated into main package feel free to open an Issue or Pull Request.

## PHPStan

While I omited most of static typing in examples above for clarity, this package is developed with level 8 of PHPStan and parts of code that are working with `mixed` values (transformers, cache object interface and cache object action) are built with generics.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

All contributions are welcome.

## Credits

- [EriBloo](https://github.com/eribloo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
