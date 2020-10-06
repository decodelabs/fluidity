# Fluidity

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/fluidity?style=flat-square)](https://packagist.org/packages/decodelabs/fluidity)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/fluidity.svg?style=flat-square)](https://packagist.org/packages/decodelabs/fluidity)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/fluidity.svg?style=flat-square)](https://packagist.org/packages/decodelabs/fluidity)
[![Build Status](https://img.shields.io/travis/com/decodelabs/fluidity/main.svg?style=flat-square)](https://travis-ci.org/decodelabs/fluidity)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat-square)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/fluidity?style=flat-square)](https://packagist.org/packages/decodelabs/fluidity)

Tools for creating fluent interfaces.


## Method chaining

```php
namespace DecodeLabs\Fluidity;

interface Then
{
    public function then(callable $callback): Then;
    public function thenEach(iterable $values, callable $callback): Then;
    public function thenWhen(bool $truth, callable $yes, callable $no=null): Then;
    public function thenUnless(bool $truth, callable $no, callable $yes=null): Then;
}
```

Create fluent object interfaces with basic generic logic structure support.

```php
use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;

$test = new class() implements Then {
    use ThenTrait;

    public function doThing(int $value=null) {}
};

$truth = true;

$test
    ->then(function($test) {
        $test->doThing();
    })

    ->thenEach([1, 2, 3], function($test, $value) {
        // Called three times
        $test->doThing($value);
    })

    ->thenWhen($truth, function($test) {
        // This gets called if($truth)
    }, function($test) {
        // This get called otherwise
    })

    ->thenUnless($truth, function($test) {
        // This gets called if(!$truth)
    }, function($test) {
        // This get called otherwise
    });
```


## Licensing

Fluidity is licensed under the MIT License. See [LICENSE](./LICENSE) for the full license text.
