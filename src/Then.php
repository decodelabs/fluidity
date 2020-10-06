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

    /**
     * @param bool $truth
     */
    public function thenIf($truth, callable $yes, callable $no = null): Then;

    /**
     * @param bool $truth
     */
    public function thenUnless($truth, callable $no, callable $yes = null): Then;
}
