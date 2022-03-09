# Fluidity

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/fluidity?style=flat)](https://packagist.org/packages/decodelabs/fluidity)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/fluidity.svg?style=flat)](https://packagist.org/packages/decodelabs/fluidity)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/fluidity.svg?style=flat)](https://packagist.org/packages/decodelabs/fluidity)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/decodelabs/fluidity/PHP%20Composer)](https://github.com/decodelabs/fluidity/actions/workflows/php.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/fluidity?style=flat)](https://packagist.org/packages/decodelabs/fluidity)

Tools for creating fluent interfaces.

## Installation

Install via Composer:

```bash
composer require decodelabs/fluidity
```

### PHP version

_Please note, the final v1 releases of all Decode Labs libraries will target **PHP8** and above._

Current support for earlier versions of PHP will be phased out in the coming months.


## Usage

### Method chaining

```php
namespace DecodeLabs\Fluidity;

interface Then
{
    public function then(callable $callback): Then;
    public function thenEach(iterable $values, callable $callback): Then;
    public function thenIf(?bool $truth, callable $yes, callable $no=null): Then;
    public function thenUnless(?bool $truth, callable $no, callable $yes=null): Then;
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

    ->thenIf($truth, function($test) {
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
