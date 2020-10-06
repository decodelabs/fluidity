<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity\Tests;

use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;

class AnalyzeTrait implements Then
{
    use ThenTrait;

    public function then(callable $callback): Then
    {
        return $this;
    }

    public function thenEach(array $values, callable $callback): Then
    {
        return $this;
    }

    public function thenIf(bool $truth, callable $yes, callable $no = null): Then
    {
        return $this;
    }

    public function thenUnless(bool $truth, callable $no, callable $yes = null): Then
    {
        return $this;
    }
};
