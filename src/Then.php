<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

interface Then
{
    public function then(callable $callback): Then;

    /**
     * @param array<mixed, mixed> $values
     */
    public function thenEach(array $values, callable $callback): Then;

    public function thenIf(bool $truth, callable $yes, callable $no = null): Then;

    public function thenUnless(bool $truth, callable $no, callable $yes = null): Then;
}
